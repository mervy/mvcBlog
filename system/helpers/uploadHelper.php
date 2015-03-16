<?php
class UploadHelper {

    protected $path = "web_files/uploads/", $file, $fileName, $fileTmpName;
    public $img, $width, $heigh;

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setFile($file) {
        $this->file = $file;
        $this->setFileName();
        $this->setFileTmpName();
        return $this;
    }

    protected function setFileName() {
        $this->fileName = $this->file['name'];
    }

    protected function setFileTmpName() {
        $this->fileTmpName = $this->file['tmp_name'];
    }

    public function upload() {
        if (move_uploaded_file($this->fileTmpName, $_SERVER["DOCUMENT_ROOT"] . $this->path . $this->fileName))
            return true;
        else
            return false;
    }

    public function setNewSize($width, $heigh) {
            $destino = $this->path . $this->file['name'];

            if ($this->file['type'] == "image/jpeg") {
                $origem = imagecreatefromjpeg($this->path . $this->file['name']);
            } else if ($this->file['type'] == "image/png") {
                $origem = imagecreatefrompng($this->path . $this->file['name']);
            } else if ($this->file['type'] == "image/gif") {
                $origem = imagecreatefromgif($this->path . $this->file['name']);
            }

            $origem_x = imagesx($origem); //pega o width da imagem de origem
            $origem_y = imagesy($origem); //pega o height da imagem de origem

            $wid_final = $width;
            $hei_final = $heigh;

            $thumb = imagecreatetruecolor($wid_final, $hei_final);

            imagecopyresampled($thumb, $origem, 0, 0, 0, 0, $wid_final, $hei_final, $origem_x, $origem_y);

            imagejpeg($thumb, $destino, 90);

            imagedestroy($origem);
            imagedestroy($thumb);          
    }

}
