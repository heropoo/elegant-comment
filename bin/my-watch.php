<?php
/**
 * Date: 2020/5/12
 * Time: 6:33 下午
 */

$watch = new Watch(['path' => __DIR__ . '/../app']);
$watch->run();;

class Watch
{
    //protected $hashes = [];
    protected $path = __DIR__;
    protected $ext = [];
    protected $interval = 2;
    protected $callback;

    public function __construct(array $options = [])
    {
        if (isset($options['path'])) {
            if (!is_dir($options['path'])) {
                throw new \Exception("Path '{$options['path']}' is not exists");
            }
            $this->path = realpath($options['path']);
        }

        if (isset($options['ext'])) {
            $this->ext = $options['ext'];
        }

        if (isset($options['interval'])) {
            $this->interval = $options['interval'];
        }

        if (isset($options['callback'])) {
            $this->callback = $options['callback'];
        }
    }

    public function run()
    {
        $n = 1;
        $hashes = $this->hashAllFile($this->path);
        //var_dump($this->hashes);
        while (1) {
            echo $n++ . PHP_EOL;
            sleep($this->interval);
            $newHashes = $this->hashAllFile($this->path);
            var_dump(array_diff($hashes, $newHashes));

            $hashes = $newHashes;
        }
    }

    public function hashAllFile($path)
    {
        $hashes = [];
        if ($handle = opendir($path)) {
            while (($file = readdir($handle)) !== false) {
                if ($file !== '.' && $file !== '..') {
                    //echo $path . DIRECTORY_SEPARATOR . $file . PHP_EOL;
                    $filename = $path . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($filename)) {
                        $res = $this->hashAllFile($filename);
                        $hashes = array_merge($hashes, $res);
                    } else {
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        if (in_array($ext, $this->ext)) {
                            $hashes[$filename] = $this->getFileHash($filename);
                        }
                    }
                }
            }
            //关闭文件夹
            closedir($handle);
        }
        return $hashes;
    }

    protected function getFileHash($filename)
    {
        $content = file_get_contents($filename);
        return md5($content);
//        return filemtime($filename);
    }
}