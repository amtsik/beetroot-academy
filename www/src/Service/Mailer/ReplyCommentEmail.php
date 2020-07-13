<?php
declare(strict_types=1);


namespace App\Service\Mailer;


use App\Entity\Comment;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\RouterInterface;

class ReplyCommentEmail
{

    private $mailer;
    private $router;

    public function __construct(MailerInterface $mailer, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendNotification(Comment $reply)
    {
        var_dump($reply);
        die();
        $email = (new TemplatedEmail())
            ->from('no-reply@s-blog.com.ua')
            ->to(new Address($reply->getReplyTo()->getUser()->getEmail()))
            ->subject('Ответ на ваш комментарий')

            // path of the Twig template to render
            ->htmlTemplate('emails/reply.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'reply' => $reply,
                'pageURL' => $this->router->generate(
                    'article_show',
                    ['id' => $reply->getArticle()->getId()]
                ),

            ]);
//        $this->mailer->send($email);
        $this->mailer->send($email);
    }
}