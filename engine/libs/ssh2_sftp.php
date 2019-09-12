<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class ssh2_sftpLibrary
{
	public function connect($hostname, $ssh_port, $locationid, $command)
	{
		if($link = ssh2_connect($hostname, 22)) {
			if(ssh2_auth_password($link, $username, $password)) {
				return $link;
			}
		}

		return 'Ошибка: Не удалось соединиться с сервером!';
	}

	public function open_w($hostname, $ssh_port, $locationid, $command, $file)
	{
		if($link = ssh2_connect($hostname, 22)) {
			if(ssh2_auth_password($link, $username, $password)) {
				$sftp = ssh2_sftp($link);
				$lol = fopen('ssh2.sftp://' . $sftp . $command, 'w');
				fwrite($lol, $file);
				return stream_get_contents($lol);
			}
		}

		return 'Ошибка: Не удалось соединиться с сервером!';
	}

	public function files($hostname, $ssh_port, $locationid, $path)
	{
		if($link = ssh2_connect($hostname, 22)) {
			if(ssh2_auth_password($link, $username, $password)) {
				$sftp = ssh2_sftp($link);
				$files = scandir('ssh2.sftp://' . $sftp . $path);
				return $files;
			}
		}

		return 'Ошибка: Не удалось соединиться с сервером!';
	}

	public function find_file($dirs, $filename, $exact = false)
	{
		$dir = @scandir($dirs);
		if (is_array($dir) && !empty($dir)) {
			foreach ($dir as $file) {
				if (($file !== '.') && ($file !== '..')) {
					if (is_file($dirs . '/' . $file)) {
						$filepath = realpath($dirs . '/' . $file);

						if (!$exact) {
							$pos = strpos($file, $filename);

							if ($pos === false) {
							}
							else {
								if (file_exists($filepath) && is_file($filepath)) {
									echo str_replace($filename, '<span style="color:red;font-weight:bold">' . $filename . '</span>', $filepath) . ' (' . round(filesize($filepath) / 1024) . 'kb)<br />';
								}
							}
						}
						else if ($file == $filename) {
							if (file_exists($filepath) && is_file($filepath)) {
								echo str_replace($filename, '<span style="color:red;font-weight:bold">' . $filename . '</span>', $filepath) . ' (' . round(filesize($filepath) / 1024) . 'kb)<br />';
							}
						}
					}
					else {
						$this->find_file($dirs . '/' . $file, $filename, $exact);
					}
				}
			}
		}
	}

	public function test($hostname, $ssh_port, $locationid, $dirs, $filename, $exact = false, $lol)
	{
		if($link = ssh2_connect($hostname, 22)) {
			if(ssh2_auth_password($link, $username, $password)) {
				$sftp = ssh2_sftp($link);

				if (!$lol) {
					$dirs = 'ssh2.sftp://' . $sftp . '/home/gs412/' . $dirs;
				}

				$dirs2 = '/home/gs412/' . $dirs;
				$dir = @scandir($dirs);
				if (is_array($dir) && !empty($dir)) {
					foreach ($dir as $file) {
						if (($file !== '.') && ($file !== '..')) {
							if (is_file($dirs . '/' . $file)) {
								$file = str_replace('ssh2.sftp://Resource id #7/home/gs412', '', $file);
								$filepath = realpath($dirs2 . '/' . $file);

								if (!$exact) {
									echo $pos = strpos($file, $filename);

									if ($pos === false) {
									}
									else {
										if (file_exists($filepath) && is_file($filepath)) {
											echo str_replace($filename, '<span style="color:red;font-weight:bold">' . $filename . '</span>', $filepath) . ' (' . round(filesize($filepath) / 1024) . 'kb)<br />';
										}
									}
								}
								else if ($file == $filename) {
									if (file_exists($filepath) && is_file($filepath)) {
										echo str_replace($filename, '<span style="color:red;font-weight:bold">' . $filename . '</span>', $filepath) . ' (' . round(filesize($filepath) / 1024) . 'kb)<br />';
									}
								}
							}
							else {
								$this->test($hostname, $ssh_port, $locationid, $dirs . '/' . $file, $filename, $exact, '1');
							}
						}
					}
				}

				return true;
			}
		}

		return 'Ошибка: Не удалось соединиться с сервером!';
	}

	public function write($cfg_get, $set_cfg)
	{
		fwrite($lol, $file);
		return stream_get_contents($lol);
	}

}
?>
