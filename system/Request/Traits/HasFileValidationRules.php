<?php

namespace System\Request\Traits;

trait HasFileValidationRules
{
  // fonction qui permet de refuser un fichier trop lourd et un fichier trop petit
  protected function maxFile($name, $size)
  {
    $size = $size * 1024;
    if($this->checkFirstError($name) && $this->checkFileExist($name)) 
    {
      if ($this->files[$name]['size'] > $size ) 
      {
        $this->setError($name, "$name size must be lower than" . ($size/1024) . "kb");
      }
    }
  }

  protected function minFile($name, $size)
  {
    $size = $size * 1024;
    if($this->checkFirstError($name) && $this->checkFileExist($name)) 
    {
      if ($this->files[$name]['size'] < $size ) 
      {
        $this->setError($name, "$name size must be greater than" . ($size/1024) . "kb");
      }
    }
  }

  // pour choisir le format de photo accepté pour l'avatar
  private function fileType($name, $typesArray)
  {
    if($this->checkFirstError($name) && $this->checkFileExist($name))
    {
      // on va chercher le type d'image envoyé
      $currentTypeFile = explode("/", $this->files[$name]['type'])[1];
      if (!in_array($currentTypeFile, $typesArray)) 
      {
        // message d'erreur
        $this->setError($name, "$name type must be". implode(",", $typesArray));	
      }
    }
  }

  protected function fileRequired($name)
  {
    // fonction pour le défaut des images(image sans nom)
    if (!isset($this->files[$name]['name']) || empty($this->files[$name]['name']) && checkFirstError($name)) 
    {
      $this->setError($name, "$name is required");
    }
  }

  protected function fileValidation($name, $ruleArray)
  {
    foreach ($ruleArray as $rule) 
    {
      //  Aller chercher si le nom est correcte
      if ($rules = 'required') 
      {
        $this->fileRequired($name);
      }
      elseif(strpos($rule, "mimes:") === 0)
      {
        // Aller chercher la deuxieme partie du type mime (extension)
        $rule = str_replace("mimes:", "", $rule);
        $rule = explode(",", $rule);
        $this->fileType($name, $rule);
      }
      elseif(strpos($rule, "max:") === 0)
      {
        // Gerer la taille des photos maximum 
        $rule = str_replace("max:", "", $rule);
        $rule->maxFile($name, $rule);
      } 
      elseif (strpos($rule, "min:") === 0) 
      {
        // Gérer la taille des photos minimum
        $rule = str_replace("min:", "", $rule);
        $rule->minFile($name, $rule);
      }
    }
  }
}