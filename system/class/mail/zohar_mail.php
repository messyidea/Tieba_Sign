<?php
if(!defined('IN_KKFRAME')) exit('Access Denied');
class zohar_mail extends mailer{
	var $id = 'zohar_mail';
	var $name = 'Zohar Mailer';
	var $description = 'Zohar提供的邮件代理发送邮件 (发送者显示 Zohar-Open-Mail-System &lt;open_mail_api@iwch.me&gt;)';
	var $config = array(
		array('<p>推荐地址</p><p>http://api.iwch.me/mail/smtp.php</p><p>更新请见<a href="https://github.com/iwch" rel="nofollow" target="_blank">GitHub</a></p>API地址', 'agentapi', '', 'http://api.iwch.me/mail/smtp.php'),
		);
	function isAvailable() {
		return true;
	}
	function post($url, $content) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	function send($mail) {
		$data = array(
			'to' => $mail -> address,
			'title' => $mail -> subject,
			'content' => $mail -> message,
			);
		$agentapi = $this -> _get_setting('agentapi');
		$sendresult = json_decode($this -> post($agentapi, $data), true);
		if ($sendresult['err_no']==0) return true;
		return false;
	}
}
?>