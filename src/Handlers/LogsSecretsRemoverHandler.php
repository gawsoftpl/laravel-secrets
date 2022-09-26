<?php

namespace Gawsoft\LaravelSecrets\Handlers;

use Gawsoft\LaravelSecrets\Actions\LogsProcess;
use Illuminate\Log\Logger;

class LogsSecretsRemoverHandler {

    function __construct(
        private LogsProcess $logsAction
    ){}

    function __invoke(Logger $logger){
       foreach($logger->getHandlers() as $handler){
           $handler->pushProcessor(function($record){
                return $this->logsAction->processRecord($record);
           });
       }

    }
}