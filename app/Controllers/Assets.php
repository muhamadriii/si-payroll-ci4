<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Assets extends Controller
{
    public function sbadmin2($path)
    {
        $base = realpath(ROOTPATH . 'template-ui/startbootstrap-sb-admin-2-gh-pages');
        if ($base === false) {
            return $this->response->setStatusCode(404);
        }
        $filePath = realpath($base . DIRECTORY_SEPARATOR . $path);
        if ($filePath === false || strncmp($filePath, $base, strlen($base)) !== 0 || !is_file($filePath)) {
            return $this->response->setStatusCode(404);
        }
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mime = $this->mimeType($ext);
        $content = file_get_contents($filePath);
        return $this->response->setContentType($mime)->setBody($content)->noCache();
    }

    private function mimeType(string $ext): string
    {
        $map = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
        ];
        return $map[$ext] ?? 'application/octet-stream';
    }
}

