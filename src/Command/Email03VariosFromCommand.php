<?php declare(strict_types=1);

namespace App\Command;

use App\Command\Base\ModelBuilderTrait;
use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;

// bin/console csf:email-03

// Hay que modificar mailer.yaml: framework -> mailer -> transports (en lugar de dsn)
// Hay que añadir la cabecera de e-mail X-Transport
final class Email03VariosFromCommand extends Command
{
    use ModelBuilderTrait;

    protected static        $defaultName = 'csf:email-03';
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $publicacionDTO = self::buildDTO();

        $this->send($publicacionDTO);
    }

    public function send(PublicacionDTO $publicacionDTO): void
    {
        $context = ['publicacion' => $publicacionDTO];

        $email = (new TemplatedEmail())
            ->from(new NamedAddress('support@myproject.ext', 'My Project'))
            ->to('admin@myproject.ext')
            ->subject('publicación modificada')
            ->context($context)
            ->htmlTemplate('notification/email-02.html.twig');

        $email->getHeaders()->addTextHeader('X-Transport', 'support@myproject.ext');
        $this->mailer->send($email);
    }
}