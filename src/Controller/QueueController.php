<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class QueueController
{
    private $messageBus;
    private $logger;

    public function __construct(MessageBusInterface $messageBus,LoggerInterface $logger)
    {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    /**
     * @Route("/queue", name="queue_index")
     */
    public function index()
    {
        // Count the number of pending messages in the default transport
        $envelopes = $this->messageBus->getTransport()->get()->all(1);
        $count = count($envelopes);
        $this->logger->info('the number of panding message',$count,".");

        return new JsonResponse([
            'count' => $count,
        ]);
    }
}