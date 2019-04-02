<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\UrlManager;
use App\Manager\UrlNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{

    /**
     * @var UrlManager
     */
    private $urlManager;

    public function __construct(
        UrlManager $urlManager
    ) {
        $this->urlManager = $urlManager;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response(file_get_contents(__DIR__ . '/../Resources/content/index.html'));
    }

    /**
     * @Route("/{urlCode}", name="redirect_by_code", methods={"GET"})
     *
     * @param string $urlCode
     *
     * @return Response
     */
    public function redirectByCode(string $urlCode): Response
    {
        try {
            return new RedirectResponse($this->urlManager->getUrl($urlCode));
        } catch (UrlNotFoundException $exception) {
            return new JsonResponse(['message' => 'need to implement exception']);
        }
    }

    /**
     * @Route("/", name="save_url", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function post(Request $request): Response
    {
        $url = $request->get('url', null);
        if (null === $url) {
            throw new \InvalidArgumentException();
        }
        $urlCode = $this->urlManager->saveUrl($url);

        return new JsonResponse(['urlShortener' => $this->generateUrl(
            'redirect_by_code',
            ['urlCode' => $urlCode->__toString()]
        )]);
    }
}
