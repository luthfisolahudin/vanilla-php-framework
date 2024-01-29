<?php

declare(strict_types=1);

namespace Sys\Http\Controller;

use Sys\Config\ConfigInterface;
use Sys\Http\Request\RequestInterface;
use Sys\Http\Status;

class ErrorController extends BaseController
{
    public function __construct(
        protected RequestInterface $request,
        protected ConfigInterface $config,
    ) {
        parent::__construct($request);
    }

    public function __invoke()
    {
        $code = http_response_code();

        return view()->render(
            $this->view($code),
            ['code' => $code, 'text' => Status::TEXTS[$code]],
        );
    }

    protected function view(int $code): string
    {
        if ($view = $this->config->get("views.errors.{$code}")) {
            return $view;
        }

        if ($view = $this->config->get('views.errors.any')) {
            return $view;
        }

        if (view()->exists("error/{$code}")) {
            return "error/{$code}";
        }

        return 'error/any';
    }
}
