<?php
Yii::import('system.gii.generators.crud.CrudCode');

class WebAppThemeCrudCode extends CrudCode
{
	public $model;
	public $controller;
	public $baseControllerClass = 'Controller';
	public $generateComponents = true;
	public $generateLayouts = true;
	public $layoutPrefix = '';
	public $theme = 'default';

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller, layoutPrefix', 'filter', 'filter' => 'trim'),
			array('model, controller, baseControllerClass, theme', 'required'),
			array('model', 'match', 'pattern' => '/^\w+[\w+\\.]*$/', 'message' => '{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern' => '/^\w+[\w+\\/]*$/', 'message' => '{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern' => '/^[a-zA-Z_]\w*$/', 'message' => '{attribute} should only contain word characters.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError' => true),
			array('theme', 'in', 'range' => array_keys($this->getThemes())),
			array('model', 'validateModel'),
			array('baseControllerClass, generateComponents, generateLayouts, layoutPrefix, theme', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model' => 'Model Class',
			'controller' => 'Controller ID',
			'baseControllerClass' => 'Base Controller Class',
			'generateComponents' => 'Generate Components and Widgets',
			'generateLayouts' => 'Generate Layouts',
			'layoutPrefix' => 'Layout Prefix',
			'theme' => 'Theme',
		));
	}

	public function requiredTemplates()
	{
		return array_merge(parent::requiredTemplates(), array(
			'layouts' . DIRECTORY_SEPARATOR . 'main.php',
		));
	}

	public function prepare()
	{
		$this->files = array();
		$templatePath = $this->templatePath;
		$controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';
		$this->files[] = new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);
		$files = scandir($templatePath);
		foreach ($files as $file)
		{
			if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php')
			{
				$this->files[] = new CCodeFile(
					$this->viewPath . DIRECTORY_SEPARATOR . $file,
					$this->render($templatePath . '/' . $file)
				);
			}
		}
		if ($this->generateComponents)
		{
			$templatePath = $this->templatePath . DIRECTORY_SEPARATOR . 'components';
			$files = scandir($templatePath);
			foreach ($files as $file)
			{
				if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php')
				{
					$this->files[] = new CCodeFile(
						Yii::getPathOfAlias('application.components') . DIRECTORY_SEPARATOR . $file,
						$this->render($templatePath . '/' . $file)
					);
				}
			}
			$templatePath = $this->templatePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'widgets';
			$files = scandir($templatePath);
			foreach ($files as $file)
			{
				if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php')
				{
					$this->files[] = new CCodeFile(
						Yii::getPathOfAlias('application.components.widgets') . DIRECTORY_SEPARATOR . $file,
						$this->render($templatePath . '/' . $file)
					);
				}
			}
		}
		if ($this->generateLayouts)
		{
			$templatePath = $this->templatePath . DIRECTORY_SEPARATOR . 'layouts';
			$files = scandir($templatePath);
			foreach ($files as $file)
			{
				if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php')
				{
					$this->files[] = new CCodeFile(
						$this->layoutPath . DIRECTORY_SEPARATOR . $file,
						$this->render($templatePath . '/' . $file)
					);
				}
			}
		}
	}

	public function getLayoutPath()
	{
		return rtrim($this->getModule()->getLayoutPath() . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $this->layoutPrefix), DIRECTORY_SEPARATOR);
	}

	public function getRelativeLayoutPath()
	{
		return rtrim('layouts/' . str_replace('.', '/', $this->layoutPrefix), '/');
	}

	public function generateInputLabel($modelClass, $column)
	{
		return "CHtml::activeLabelEx(\$model, '{$column->name}', array('class' => 'label'))";
	}

	public function generateActiveLabel($modelClass, $column)
	{
		return "\$form->labelEx(\$model, '{$column->name}', array('class' => 'label'))";
	}

	public function generateInputField($modelClass, $column)
	{
		if ($column->type === 'boolean')
		{
			return "CHtml::activeCheckBox(\$model, '{$column->name}', array('class' => 'label'))";
		}
		else
		{
			if (stripos($column->dbType, 'text') !== false)
			{
				return "CHtml::activeTextArea(\$model, '{$column->name}', array('rows' => 6, 'cols' => 50, 'class' => 'text_area'))";
			}
			else
			{
				if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
				{
					$inputField = 'activePasswordField';
				}
				else
				{
					$inputField = 'activeTextField';
				}
				if ($column->type !== 'string' || $column->size === null)
				{
					return "CHtml::{$inputField}(\$model, '{$column->name}', array('class' => 'text_field'))";
				}
				else
				{
					if (($size = $maxLength = $column->size) > 60)
					{
						$size = 60;
					}
					return "CHtml::{$inputField}(\$model, '{$column->name}', array('size' => {$size}, 'maxlength' => {$maxLength}, 'class' => 'text_field'))";
				}
			}
		}
	}

	public function generateActiveField($modelClass, $column)
	{
		if ($column->type === 'boolean')
		{
			return "\$form->checkBox(\$model, '{$column->name}')";
		}
		else
		{
			if (stripos($column->dbType, 'text') !== false)
			{
				return "\$form->textArea(\$model, '{$column->name}', array('rows' => 6, 'cols' => 50, 'class' => 'text_area'))";
			}
			else
			{
				if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
				{
					$inputField = 'passwordField';
				}
				else
				{
					$inputField = 'textField';
				}
				if ($column->type !== 'string' || $column->size === null)
				{
					return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'text_field'))";
				}
				else
				{
					if (($size = $maxLength = $column->size) > 60)
					{
						$size = 60;
					}
					return "\$form->{$inputField}(\$model, '{$column->name}', array('size' => {$size}, 'maxlength' => {$maxLength}, 'class' => 'text_field'))";
				}
			}
		}
	}

	public function getThemes()
	{
		return array(
			'default' => 'Default',
			'activo' => 'Activo 2',
			'red' => 'Red',
			'amro' => 'Amro',
			'bec' => 'Bec',
			'bec-green' => 'Bec-Green',
			'blue' => 'Blue',
			'djime-cerulean' => 'Djime-Cerulean',
			'drastic-dark' => 'Drastic Dark',
			'kathleene' => 'Kathleene',
			'olive' => 'Olive',
			'orange' => 'Orange',
			'reidb-greenish' => 'Greenish',
			'warehouse' => 'Warehouse',
		);
	}
}
