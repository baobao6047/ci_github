<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文件操作
 */
class Test extends CI_Controller
{
    private $application_folder = 'dirname(dirname(__FILE__))';

    public function __construct()
    {
        parent::__construct();
    }

    //--------------------------------------------------------------------

    /**
     * 读取文件显示在页面
     */
    public function dir_view()
    {
        $application_path = dirname(dirname(__FILE__)) . '/'; // 项目根目录
        $dir_path = $application_path . 'logs'; // 文件目录

        if (!is_dir($dir_path)) {
            show_error($dir_path . '文件不存在');
        }

        /*
        glob() 函数返回匹配指定模式的文件名或目录。
            Array(
                [0] => F:\hcdemo\application/logs/index.html
                [1] => F:\hcdemo\application/logs/tet.txt)
        */
        $files = glob($dir_path . '/*');

        $list = array();
        foreach ($files as $file) {
            /*
            basename() 函数返回路径中的文件名部分。
                Array(
                    [0] => index.html
                    [1] => tet.txt)
            */
            $list[] = basename($file);
        }

        $this->load->view('dir_view',$list);
    }

    //--------------------------------------------------------------------

    /**
     * 下载文件
     * file_name 文件名(log.txt)
     */
    public function down_load($file_name)
    {
        $application_path = dirname(dirname(__FILE__)) . '/'; // 项目根目录
        $file = $application_path . 'logs/' . $file_name; // 文件路径
        if (!file_exists($file)) {
            show_error("workerman.log不存在");
        }
        header('Content-Type: "text/plain"');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: " . filesize($file));
        readfile($file);
    }

    //--------------------------------------------------------------------

    /**
     * 写入文件
     */
    public function update_file()
    {
        $application_path = dirname(dirname(__FILE__)) . '/'; // 项目根目录
        $file = $application_path . 'config/content.php'; // 文件路径

        $temp = '这是要写入的内容';
        $content = "<?php\r\n";
        $content = $content . "\$config['content']=array(\r\n";
        $content = $content . "'temp'=>" . $temp . ",\r\n";
        $content = $content . ");";

         /*
            file_put_contents() 函数把一个字符串写入文件中。
            与依次调用 fopen()，fwrite() 以及 fclose() 功能一样。
          */
        $ret = file_put_contents($file, $content, LOCK_EX);
        return $ret ? true : false;
    }

    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------

}
