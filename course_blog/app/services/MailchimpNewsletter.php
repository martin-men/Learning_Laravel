<?php

namespace App\services;

class MailchimpNewsletter implements Newsletter
{
    public function subscribe(string $email, string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');

        return $this->getClient()->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }

    protected function getClient()
    {
        $mailchimp = new \MailchimpMarketing\ApiClient();

        return $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us12'
        ]);
    }
}
