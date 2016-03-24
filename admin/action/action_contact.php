<?php

$data = <<<EOT
<?php

\$_CINFO['qq'] = '{$_POST['qq']}';
\$_CINFO['tel'] = '{$_POST['tel']}';
// 传真
\$_CINFO['fax'] = '{$_POST['fax']}';

\$_CINFO['weibo'] = '{$_POST['weibo']}';
\$_CINFO['weixin'] = '{$_POST['weixin']}';
\$_CINFO['mail'] = '{$_POST['mail']}';

?>
EOT;

file_put_contents('contact.inc.php', $data);

header('Location: contact_us_content.php?flag=1');

?>