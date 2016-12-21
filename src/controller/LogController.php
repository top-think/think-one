<?php

namespace think\one\controller;

class LogController extends BaseController
{

    /**
     * 日志列表
     * @return string
     */
    public function index()
    {
        $files = glob(LOG_PATH . '*');
        $list  = [];
        foreach ($files as $file) {
            $list[] = str_replace(LOG_PATH, '', $file);
        }
        $this->title = '日志列表';
        $this->assign('list', array_reverse($list));
        return $this->fetch();
    }

    /**
     * 某月的日志列表
     * @param string $month
     * @return string
     */
    public function month($month = '')
    {
        $files = glob(LOG_PATH . $month . '/*.*');
        $logs  = [];
        foreach ($files as $file) {
            $logs[] = [
                'name' => str_replace(LOG_PATH, '', $file),
                'size' => $this->sizeFormat(filesize($file)),
                'path' => str_replace('\\', '/', $file),
            ];
        }
        $this->title = '日志列表';
        $this->assign('logs', array_reverse($logs));
        return $this->fetch();
    }

    /**
     * 显示日志详情
     * @param string $name
     * @param int    $start
     * @param int    $limit
     * @return string|\think\response\Json
     */
    public function detail($name = '', $start = 1, $limit = 20)
    {
        if (!$this->request->isAjax()) {
            $this->title = '日志详情';
            return $this->fetch();
        }
        $filename  = LOG_PATH . $name;
        $file      = file($filename);
        $countLine = count($file);

        if ($start > $countLine - $limit + 1) {
            $start = $countLine - $limit + 1;
        }
        if ($start < 1) {
            $start = 1;
        }

        $end = $start + $limit - 1;
        if ($end > $countLine) {
            $end = $countLine;
        }

        $content = [];
        for ($i = $start - 1; $i < $end; $i++) {
            if (isset($file[$i])) {
                $content[$i + 1] = $file[$i];
            }
        }

        $log = [
            'name'    => $name,
            'size'    => $this->sizeFormat(filesize($filename)),
            'path'    => str_replace('\\', '/', $filename),
            'line'    => $countLine,
            'start'   => (int) $start,
            'end'     => (int) $end,
            'content' => $content,
        ];

        return json($log);
    }

    public function delete($name = '')
    {
        unlink(LOG_PATH . $name);
    }

    public function watch()
    {
        return $this->fetch();
    }

    /**
     * 文件大小格式化
     * @param integer $size 初始文件大小，单位为byte
     * @return array 格式化后的文件大小和单位数组，单位为byte、KB、MB、GB、TB
     */
    private function sizeFormat($size = 0, $dec = 2)
    {
        $unit = ["B", "KB", "MB", "GB", "TB", "PB"];
        $pos  = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        $result['size'] = round($size, $dec);
        $result['unit'] = $unit[$pos];
        return $result['size'] . $result['unit'];
    }

}
