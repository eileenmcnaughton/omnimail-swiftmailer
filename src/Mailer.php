<?php

namespace Omnimail\Swiftmailer;

use Omnimail\Common\AbstractMailer;
use Omnimail\EmailSenderInterface;
use Omnimail\EmailInterface;
use Swift_Mailer;
use Swift_Transport;
use Swift_MailTransport;
use Swift_Message;


/**
 * Created by IntelliJ IDEA.
 * User: emcnaughton
 * Date: 4/4/17
 * Time: 12:12 PM
 */
class Mailer extends AbstractMailer implements EmailSenderInterface
{

  /**
   * Transport object - see http://swiftmailer.org/docs/sending.html#
   *
   * @var Swift_Transport
   */
    protected $transport;

  /**
   * Get the transport method.
   *
   * Currently only supporting mail as this is mostly proof of concept.
   * @return Swift_Transport
   */
  public function getTransport() {
    return Swift_MailTransport::newInstance();
  }

  /**
   * @param \Omnimail\Swiftmailer\Swift_Transport $transport
   */
  public function setTransport($transport) {
    $this->transport = $transport;
  }


    public function send(EmailInterface $email) {
      // Swiftmailer supports multiple transports, but implementation is currently Mail.
      // Unsure it will make sense to have a mailer object per transport, or have
      // Swift Mailer encourage setting of the transport. If feels like if the latter
      // it should be more like 'Mail' than an object that gets specified.
      $transport = $this->getTransport();

      $mailer = Swift_Mailer::newInstance($transport);
      $fromVars = $email->getFrom();
      $from = array($fromVars['email'] => $fromVars['name']);
      $toVars = $email->getTos();
      $to = array();
      foreach ($toVars as $toVar) {
          if ($toVar['name']) {
            $to[] = array($toVar['email'] => $toVar['name']);
          }
          else {
            $to[] = $toVar['email'];
          }
      }

      $message = Swift_Message::newInstance($email->getSubject())
        ->setFrom($from)
        ->setTo($to)
        ->setBody($email->getHtmlBody())
      ;

      $mailer->send($message);
    }


}
