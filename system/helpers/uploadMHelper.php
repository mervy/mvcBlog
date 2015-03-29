<?php

class uploadMHelper
{
    /**
     * Para upar para um banco de dados pode-se usar
     * $nomes = implode(', ', $_FILES['files']['name']);
     * ficando assim: flatbow1.jpg, plate6.jpg, Plate_3_Flat_Bow_and_Bowyers_Knot.jpg, tfood41e.gif, xljhcl.jpg, xr3dM0T.jpg.
     */
    protected $path = 'web_files/uploads/', $file, $fileName, $fileTmpName;

    public function setPath($path)
    {
        if (!is_dir($path)) {
            mkdir("$path", 0755);
            $this->path = '/'.$path;
        } else {
            $this->path = '/'.$path;
        }

        return $this;
    }

    public function setFile($file)
    {
        $this->file = $file;
        $this->setFileName();
        $this->setFileTmpName();

        return $this;
    }

    protected function setFileName()
    {
        $this->fileName = $this->file['name'];
    }

    protected function setFileTmpName()
    {
        $this->fileTmpName = $this->file['tmp_name'];
    }

    public function upload()
    {
        for ($i = 0; $i < count($this->fileName); $i++) {
            if (!move_uploaded_file($this->fileTmpName[$i], $_SERVER['DOCUMENT_ROOT'].$this->path.$this->fileName[$i])) {
                throw new Exception('Houve um erro com o Upload!');
            }
        }
    }
}
