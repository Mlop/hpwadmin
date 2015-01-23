<?php

/**
 * Extends CWebApplication.
 */
class WebApplication extends CWebApplication
{

    /**
     * @See WebeezUrlManager::staticUrl
     */
    public function staticUrl($url, array $options = array())
    {
        return self::getUrlManager()->staticUrl($url, $options);
    }

    /**
     * Print JSON data and end the application.
     *
     * @param mixed $data Any data that will be rendered as JSON format.
     *
     * @return void
     */
    public function endJson($data)
    {
        if (is_array($data)) {
            if (!isset($data['ok'])) {
                $data['ok'] = true;
            }
        }

        if (!$ctx = @CJSON::encode($data)) {
            header('HTTP/1.1 204 No Content');
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo $ctx;
        }
        $this->end();
    }
}
