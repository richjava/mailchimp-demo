<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mailchimp demo</title>
    </head>
    <body>
        <h2>Mailchimp demo</h2>
        <?php
        include('libraries/Mailchimp.php');

        use \DrewM\MailChimp\MailChimp;

        $mailChimp = new MailChimp('your-api-key-goes-here');
        print_r('Getting list...<br><br>');
        //get all lists
        $listData = $mailChimp->get('lists');
        //if lists exist, get the id of the first list and add a subscriber to it.
        if ($listData) {
            $listId = $listData['lists'][0]['id'];
            print_r('Mailchimp list id is: ' . $listId . '<br><br>');
            $subscriberEmail = 'richjavalabs@gmail.com';

            print_r('Adding subscriber...<br><br>');
            //add subscriber
            $subscriber = $mailChimp->post("lists/$listId/members", [
                'email_address' => $subscriberEmail,
                'status' => 'subscribed',
            ]);
            if (isset($subscriber['id'])) {
                print_r('Mailchimp subscriber id is: ' . $subscriber['id'] . '<br><br>');

                print_r('Deleting subscriber...<br><br>');
                //delete the subscriber
                $subscriber_hash = $mailChimp->subscriberHash($subscriberEmail);
                $mailChimp->delete("lists/$listId/members/$subscriber_hash");
            } else {
                print_r($subscriber['detail'] . '<br><br>');
            }
        }
        ?>
    </body>
</html>
