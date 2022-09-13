<?php

class mail
{
	var $headers;
	var $multipart;
	var $mime;
	var $html;
	var $parts = array ();
	private $images = 1;

	function mail ($headers = "")
	{
		$this->headers = $headers;
	}

	function add_html ($html = "")
	{
		$this->html .= $html;
	}

	function build_html ($orig_boundary, $charset)
	{
		$this->multipart .= "--$orig_boundary\n";
		$this->multipart.="Content-Type: text/html; charset=$charset\n";
		$this->multipart.="Content-Transfer-Encoding: Quot-Printed\n\n";
		$this->multipart.="$this->html\n\n";
	}


	function add_attachment ($path = "", $name = "", $c_type = "application/octet-stream")
	{
		if (!file_exists ($path . $name))
		{
			return;
		}
		$fp = fopen ($path.$name, "r");
		if (!$fp)
		{
			return;
		}
		$file = fread ($fp, filesize ($path.$name));
		fclose ($fp);
		$this->parts[] = array ("body" => $file, "name" => $name, "c_type" => $c_type);
	}


	function build_part ($i)
	{
		$message_part = "";
		$message_part .= "Content-Type: ".$this->parts[$i]["c_type"];
		if ($this->parts[$i]["name"]!="")
		{
			$message_part .= "; name = \"".$this->parts[$i]["name"]."\"\n";
		}
		else
		{
		   $message_part.="\n";
		}
		$message_part .= "Content-Transfer-Encoding: base64\n";
		if (eregi (".\(gif|png|jpg|jpeg|bmp)$", $this->parts[$i]["name"]))
		{
			$message_part .= "Content-ID: <IMAGE".$this->images.">\n\n";
			$this->images ++;
		}
		else
		{
			$message_part .= "Content-Disposition: attachment; filename = \"". $this->parts[$i]["name"]."\"\n\n";
		}
		$message_part .= chunk_split(base64_encode($this->parts[$i]["body"]))."\n";
		return $message_part;
	}


	function build_message ($charset)
	{
		$boundary="=_".md5(uniqid(time()));
		$this->headers .= "MIME-Version: 1.0\n";
		$this->headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
		$this->multipart = "";
		$this->build_html ($boundary, $charset);
		for ($i = (count ($this->parts) - 1); $i >= 0; $i --)
		{
			$this->multipart.="--$boundary\n".$this->build_part ($i);
		}
		$this->mime = "$this->multipart--$boundary--\n";
	}


	function send ($server, $to, $from, $subject="", $headers="")
	{
		$headers = "To: $to\nFrom: $from\nSubject: $subject\nX-Mailer: Informico!\n".$this->headers;
		//$fp = fsockopen ($server, 25, &$errno, &$errstr, 30);
		$sendmail = "/usr/sbin/sendmail -t";
		$fp = popen ($sendmail, "w");
		if (!$fp)
		{
			die("Server $server. Connection failed: $errno, $errstr");
		}
		fputs ($fp, $headers."\n");
		fputs ($fp, $this->mime);
		pclose ($fp);
		/*fputs($fp,"HELO $server\n");
		fputs($fp,"MAIL FROM: $from\n");
		fputs($fp,"RCPT TO: $to\n");
		fputs($fp,"DATA\n");
		fputs($fp,$this->headers);
		if (strlen($headers))
		  fputs($fp,"$headers\n");
		fputs($fp,$this->mime);
		fputs($fp,"\n.\nQUIT\n");
		while(!feof($fp))
		{
			$resp .= fgets($fp,1024);
		}
		echo $resp;
		fclose($fp);*/
	}
}
?>
