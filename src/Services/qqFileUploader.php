<?php
namespace App\Services;

use App\Services\ResizeImg;
use App\Services\qqUploadedFileForm;
use App\Services\qqUploadedFileXhr;

class qqFileUploader {
  protected $assignedName;
  protected $filename_secure;
  protected $allowedExtensions = array();
  protected $sizeLimit = 10485760;
  protected $file;
  protected $type;
  protected $id_product;
  protected $resize;
  //public $products_images_manage;
  public $product_manage;

  function __construct(?string $assignedName, array $allowedExtensions = array(), $sizeLimit = 10485760, $filename_secure = false)
  {
    $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
    $this->allowedExtensions = $allowedExtensions;        
    $this->sizeLimit = $sizeLimit;
    $this->assignedName = $assignedName;
    $this->filename_secure = $filename_secure;
    $this->resize = new ResizeImg();
        
    $this->checkServerSettings();       

    if (isset($_GET['qqfile'])) {
      $this->file = new qqUploadedFileXhr();
    } elseif (isset($_FILES['qqfile'])) {
      $this->file = new qqUploadedFileForm();
    } else {
      $this->file = false; 
    }
    if(isset($_GET['type']) && isset($_GET['id_product'])) {
      if($_GET['type'] == 'product') {
        $this->type = 'product';
        $this->id_product = $_GET['id_product'];
      } elseif($_GET['type'] == 'numeric') {
        $this->type = 'numeric';
        $this->id_product = $_GET['id_product'];
      }
    } else {
      $this->type = 'media';
      }
  }

  public function setType($type) {
    $this->type = $type;
  }

  public function type() {
    return $this->type;
  }

  public function setAssignedName($assignedName) {
    $this->assignedName = $assignedName;
  }

  public function getAssignedName() {
    return $this->assignedName;
  }
    
  public function getName() {
    if ($this->assignedName) {
      return $this->getAssignedName();
    } else {
      if ($this->file) {
        $pathinfo = pathinfo($this->file->getName());
        return $filename = $pathinfo['filename'];
        //return $this->file->getName();
      }
    }
  }
    
  private function checkServerSettings(){        
    $postSize = $this->toBytes(ini_get('post_max_size'));
    $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));
  }
    
  private function toBytes($str){
    $val = trim($str);
    $last = strtolower($str[strlen($str)-1]);
    $val = intval($val);
    switch($last) {
      case 'g': $val *= 1024;
      case 'm': $val *= 1024;
      case 'k': $val *= 1024;        
    }
    return $val;
  }
    
  /**
   * Returns array('success' => true, 'newFilename' => 'myDoc123.doc') or array('error' => 'error message')
   */
  function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
    if (!is_writable($uploadDirectory)){
      return array('error' => "Erreur du serveur. Le répertoire de téléchargement n'est pas accessible en écriture.");
    }
        
    if (!$this->file){
      return array('error' => 'Aucun fichier n\'a été téléchargé.');
    }
        
    $size = $this->file->getSize();
        
    if ($size == 0) {
      return array('error' => 'Le fichier est vide.');
    }
        
    if ($size > $this->sizeLimit) {
      return array('error' => 'Le fichier est trop lourd.');
    }
        
    $pathinfo = pathinfo($this->file->getName());
    //$filename = $pathinfo['filename'];
    $filename = $this->getName();
    //$filename = md5(uniqid());
    $ext = @$pathinfo['extension'];     // hide notices if extension is empty

    if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
      $these = implode(', ', $this->allowedExtensions);
      return array('error' => 'Le fichier a une extension non valide, il doit être de type '. $these . '.');
    }
        
    if(!$replaceOldFile){
      /// don't overwrite previous files that were uploaded
      while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
        $filename.= rand(10, 99);
      }
    }
 
    if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
      //$finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = mime_content_type($uploadDirectory . $filename . '.' . $ext);
            
      if($this->type == 'numeric') {
        rename($uploadDirectory . $filename . '.' . $ext, $uploadDirectory . $this->filename_secure);
      }

      //On créée une copie des fichiers sous différentes tailles uniquement si ce ne sont pas des numérics
      if($this->type == 'product') {
        $ext = strtolower($ext);
        $dimension = getimagesize($uploadDirectory . $filename . '.' . $ext);
        // Si les dimensions ne dépassent la valeur 150px, l'image est trop petite pour la duplication dans les autres tailles.
        // On crée donc un carré à partir de sa taille original
        if ($dimension[0] <= 150) {
          if ($this->type == 'product') {
            if(!is_dir($uploadDirectory . 'square/')) mkdir($uploadDirectory . 'square/', 0777, true);
              $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . 'square/' . $filename . '.' . $ext, $ext, $dimension[0], true);
            }
          }
          if($dimension[0] > 150) {
            if($this->type == 'product') {
            if(!is_dir($uploadDirectory . '150/')) mkdir($uploadDirectory . '150/', 0777, true);
            if(!is_dir($uploadDirectory . 'square/')) mkdir($uploadDirectory . 'square/', 0777, true);
            if(!is_dir($uploadDirectory . 'square/150/')) mkdir($uploadDirectory . 'square/150/', 0777, true);
            $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . '150/' . $filename . '.' . $ext, $ext, 150, false);
            //On duplique également l'image dans un carré
            $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . 'square/150/' . $filename . '.' . $ext, $ext, 150, true);
          }
        }
        if($dimension[0] > 300) {
          if($this->type == 'product') {
            if(!is_dir($uploadDirectory . '300/')) mkdir($uploadDirectory . '300/', 0777, true);
            if(!is_dir($uploadDirectory . 'square/')) mkdir($uploadDirectory . 'square/', 0777, true);
            if(!is_dir($uploadDirectory . 'square/300/')) mkdir($uploadDirectory . 'square/300/', 0777, true);
            $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . '300/' . $filename . '.' . $ext, $ext, 300, false);
            $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . 'square/300/' . $filename . '.' . $ext, $ext, 300, true);
          }
        }
        if($dimension[0] > 850) {
          if($this->type == 'product') {
              if(!is_dir($uploadDirectory . '850/')) mkdir($uploadDirectory . '850/', 0777, true);
              if(!is_dir($uploadDirectory . 'square/')) mkdir($uploadDirectory . 'square/', 0777, true);
              if(!is_dir($uploadDirectory . 'square/850/')) mkdir($uploadDirectory . 'square/850/', 0777, true);
              $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . '850/' . $filename . '.' . $ext, $ext, 850, false);
              $this->resize->resizeImg( $uploadDirectory . $filename . '.' . $ext, $uploadDirectory . 'square/850/' . $filename . '.' . $ext, $ext, 850, true);
            }
        }
      }
      return array('success' => true, 'newFilename' => $filename . '.' . $ext);
    } else {
      return array('error' => 'Impossible d\'enregistrer le fichier téléchargé.' .
                'Le téléchargement a été annulé ou une erreur de serveur s\'est produite.');
    }
  }    
}
