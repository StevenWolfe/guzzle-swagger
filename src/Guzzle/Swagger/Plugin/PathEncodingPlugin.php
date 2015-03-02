<?php

namespace Guzzle\Swagger\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PathEncodingPlugin implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array (
            'client.create_request' => 'onClientCreateRequest',
            //'command.before_prepare' => 'onClientCreateRequest',
            //'command.after_prepare' => 'onClientCreateRequest',
            'request.before_send' => 'onRequestBeforeSend'
        );
    }

    public function onClientCreateRequest(Event $event)
    {
        /** @var Request $request */
        $request = $event['request'];
        if (empty($request)) {
            return;
        }

        $url = $request->getUrl(true);
        if (empty($url)) {
            return;
        }

        $path = $url->getPath();
        $path = rawurldecode($path);
        $path = str_replace('//', '/', $path);

        //$url->setPath($path);
        $request->setPath($path);
    }

    public function onRequestBeforeSend(Event $event)
    {
        /** @var Request $request */
        $request = $event['request'];
    }
}
