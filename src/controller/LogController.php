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
        $this->assign('logs', $logs);
        return $this->fetch();
    }

    public function detail($name = '', $start = 0, $end = null)
    {
        if (!$this->request->isAjax()) {
            $this->title = '日志详情';
            return $this->fetch();
        }
        $file  = LOG_PATH . $name;
        $count = count(file($file));

        if ($start < 1) {
            $start = 1;
        }
        if ($start > $count - 20) {
            $start = $count - 20;
        }
        if ($end == null) {
            $end = $start + 20;
        }
        if ($end > $count) {
            $end = $count;
        }
        $log = [
            'name'    => $name,
            'size'    => $this->sizeFormat(filesize($file)),
            'path'    => str_replace('\\', '/', $file),
            'line'    => $count,
            'start'   => (int) $start,
            'end'     => (int) $end,
            'content' => $this->read($name, $start, $end),
        ];

        return json($log);
    }

    private function read($name, $start = 1, $end = -1)
    {
        $file   = file(LOG_PATH . $name);
        $result = [];
        for ($line = $start - 1; $line < $end - 1; $line++) {
            $result[$line + 1] = $file[$line];
        }
        return $result;
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
