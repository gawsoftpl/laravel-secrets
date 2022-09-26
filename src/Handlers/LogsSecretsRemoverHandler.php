<?php

namespace Gawsoft\LaravelSecrets\Handlers;

use Gawsoft\LaravelSecrets\Actions\Logs;
use Illuminate\Log\Logger;

class LogsSecretsRemoverHandler {

    function __construct(
        private Logs $logsAction
    ){}

    function __invoke(Logger $logger){
       foreach($logger->getHandlers() as $handler){
           $handler->pushProcessor(function($record){
                return $this->logsAction->processRecord($record);
           });
       }

    }
}