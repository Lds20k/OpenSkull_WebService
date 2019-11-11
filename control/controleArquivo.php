<?php

class ControleArquivo{
	private $diretorio;
	private $arquivoTransferido;
	private $nomeArquivo;

    public function __construct($diretorio, $arquivoTransferido)
	{
		$extencao = pathinfo($arquivoTransferido->getClientFilename(), PATHINFO_EXTENSION);
		$nomeBase = bin2hex(random_bytes(8));
		$this->nomeArquivo 		  = sprintf('%s.%0.8s', $nomeBase, $extencao);
		$this->diretorio 		  = $diretorio;
		$this->arquivoTransferido = $arquivoTransferido;
		$this->moverArquivoTemp();
	}

	public function getNomeArquivo(){
		return $this->nomeArquivo;
	}

	public function getArquivoTemp(){
		return 'temp/'.$this->nomeArquivo;
	}

	public function limparTemp(){
		$arquivos = glob('temp/*');
		foreach($arquivos as $arquivo){
			if(is_file($arquivo)){
				unlink($arquivo);
			}
		}
	}

	public function moverArquivo(){
		if(!file_exists($this->diretorio)){
			try {
				mkdir($this->diretorio, 0777, true);
			} catch (Exception $ex) {
				throw new Exception('Erro ao criar diretorio!');
			}
		}
		rename('temp/'.$this->nomeArquivo, $this->diretorio . DIRECTORY_SEPARATOR . $this->nomeArquivo);
	}

	private function moverArquivoTemp(){
		if(!file_exists('temp')){
			try {
				mkdir('temp', 0777, true);
			} catch (Exception $ex) {
				throw new Exception('Erro ao criar diretorio!');
			}
		}
		$this->arquivoTransferido->moveTo('temp' . DIRECTORY_SEPARATOR . $this->nomeArquivo);
	}
}