<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\RouterInterface;

class SubscriptionCommand extends Command
{
    protected static $defaultName = 'app:subscription';

    private $em;
    private $mailer;
    private $router;
    private $appPort;

    public function __construct(string $name = null, EntityManagerInterface $em, MailerInterface $mailer, RouterInterface $router, $appPort)
    {
        parent::__construct(self::$defaultName);
        $this->em = $em;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->appPort = $appPort;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $this->router->getContext()->setHttpPort($this->appPort);

        $articles = $this->getFreshArticles();
        $users = $this->em->getRepository(User::class)->findBy(['is_subscribe' => '1']);

//        foreach ($articles as $article) {
//            $articlesURL[] = $this->router->generate(
//                'article_show',
//                ['id' => $article->getId()]
//            );
//        }

        foreach ($users as $user)
        {
            $email = (new TemplatedEmail())
                ->from('no-reply@s-blog.com.ua')
                ->to(new Address($user->getEmail()))
                ->subject('Новые статьи')

                // path of the Twig template to render
                ->htmlTemplate('emails/subscribe.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'articles' => $articles,
                    'user' => $user
                ]);



//        $this->mailer->send($email);
            $this->mailer->send($email);
        }

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    private function getFreshArticles($limit = 10)
    {
        return $this->em->createQueryBuilder()
            ->from(Article::class, 'a')
            ->select('a')
            ->orderBy('a.createdAt', 'desc')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
