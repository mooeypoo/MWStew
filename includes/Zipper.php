<?php

namespace MWStew;

class Zipper {
	protected $zip;
	protected $zipBaseName = 'mwstew_';

	protected $zipTempFolder = 'temp/';

	public function __construct( $tempFolderPath = '', $extName = '') {
		$this->extName = $extName;
		$this->zipTempFolder = $tempFolderPath;

		$this->filename = $this->zipBaseName . $extName . '_' . time() . $this->random() . '.zip';
		$this->zip = new \ZipArchive();
		if ( $this->zip->open( $this->zipTempFolder . $this->filename, \ZipArchive::CREATE ) !== TRUE ) {
			throw new \Exception( 'Could not open new zip file.' );
		}
	}

	/**
	 * Add files to the zip file by structure. The structure object
	 * should look like this:
	 * {
	 * 	'filename.php' => 'Content of the file',
	 *	'folder/filename2.txt' => 'Content of the file',
	 * }
	 * @param array $fileStructure Structure and content of the files
	 */
	public function addFilesToZip( $fileStructure ) {
		foreach ( $fileStructure as $dir => $content ) {
			$this->zip->addFromString( $dir, $content );
		}
		$this->zip->close();
	}

	public function download() {
		// Send for download
		ignore_user_abort( true );
		header( 'Pragma: public' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Cache-Control: public' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename="' . basename( $this->filename ) . '"'  );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Content-Length: ' . filesize( $this->zipTempFolder . $this->filename  ) );
		ob_end_flush();
		@readfile( $this->zipTempFolder . $this->filename );
		// Delete the temporary zip
		unlink( $this->zipTempFolder . $this->filename );
	}

	protected function random() {
		return mt_rand( 100, 99999 );
	}
}
