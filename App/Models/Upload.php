<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;


    public static $max_upload_size;
    public static $mime;
    protected $file;
    protected $savePath = 'assets/admin/uploads/';
    protected $userPath = '';
    protected $name;
    public $userSuggestedName = null;
    protected $fileExt;

    public function getFileExt ($file) {
        $expandName = explode('.', $file->getClientOriginalName());
        $this->fileExt = $expandName[count($expandName)-1];
        return  $expandName[count($expandName)-1];
    }

    public function __construct($file = null) {
        $this->file = $file;
        $expandName = explode('.', $file->getClientOriginalName());
        $this->fileExt = $expandName[count($expandName)-1];
    }
    
    private function setFileName ($fileName = '') {
        if ($fileName == '') {
            $this->name = time() . '_' . $this->file->getClientOriginalName();
        } else {
            $this->userSuggestedName = time() . '_' . $fileName;
        }
    }

    /**
     * try to upload target file according to givin path from user or the default path.
     * 
     * @return \boolean true when file upload succeed or false when error
    **/

    public function uploadFile($userPath = '', $fileName = '') {

        if ($this->storeFile($userPath,  $fileName)) {
            return true;
        }

    }


    /**
     * try to upload target file according to givin path from user or the default path.
     * 
     * @return \boolean true when file upload succeed or false when error
    **/
    protected function storeFile($userPath = '', $fileName = null) {
        $this->userPath = $userPath;
        $this->setFileName($fileName);
        $saveName = $this->userSuggestedName != null ? $this->userSuggestedName: $this->name;
        $this->fileSaveName =$this->savePath.$userPath.$saveName;
        try {
            move_uploaded_file($this->file, $this->fileSaveName);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }


 /**
     * return the file save path.
     * 
     * @return \String the full file path
    **/
    public function getSavePath() {
         
        return str_replace('/', '.', $this->savePath.$this->fileSaveName);

    }



}
