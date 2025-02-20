<?php
	class NumeroALetras{
		private $unidades = [
			'',
			'UNO ',
			'DOS ',
			'TRES ',
			'CUATRO ',
			'CINCO ',
			'SEIS ',
			'SIETE ',
			'OCHO ',
			'NUEVE ',
			'DIEZ ',
			'ONCE ',
			'DOCE ',
			'TRECE ',
			'CATORCE ',
			'QUINCE ',
			'DIECISÉIS ',
			'DIECISIETE ',
			'DIECIOCHO ',
			'DIECINUEVE ',
			'VEINTE ',
		];
		private $decenas = [
			'VEINTI',
			'TREINTA ',
			'CUARENTA ',
			'CINCUENTA ',
			'SESENTA ',
			'SETENTA ',
			'OCHENTA ',
			'NOVENTA ',
			'CIEN ',
		];

		private $centenas = [
			'CIENTO ',
			'DOSCIENTOS ',
			'TRESCIENTOS ',
			'CUATROCIENTOS ',
			'QUINIENTOS ',
			'SEISCIENTOS ',
			'SETECIENTOS ',
			'OCHOCIENTOS ',
			'NOVECIENTOS ',
		];

		private $acentosExcepciones = [
			'VEINTIDOS'  => 'VEINTIDÓS ',
			'VEINTITRES' => 'VEINTITRÉS ',
			'VEINTISEIS' => 'VEINTISÉIS ',
		];

		public $conector = 'CON';

		public $apocope = false;

		public function toWords(float|int $number, int $decimals = 2): string{
			$this->checkApocope();

			$number = number_format($number, $decimals, '.', '');

			$splitNumber = explode('.', $number);

			$splitNumber[0] = $this->wholeNumber($splitNumber[0]);

			if (!empty($splitNumber[1])) {
				$splitNumber[1] = $this->convertNumber($splitNumber[1]);
			}

			return $this->concat($splitNumber);
		}
	
		public function toMoney(float $number, int $decimals = 2, string $currency = '', string $cents = ''): string{
			$this->checkApocope();

			$number = number_format($number, $decimals, '.', '');

			$splitNumber = explode('.', $number);

			$splitNumber[0] = $this->wholeNumber($splitNumber[0]) . ' ' . mb_strtoupper($currency, 'UTF-8');

			if (!empty($splitNumber[1])) {
				$splitNumber[1] = $this->convertNumber($splitNumber[1]);
			}

			if (!empty($splitNumber[1])) {
				$splitNumber[1] .= ' ' . mb_strtoupper($cents, 'UTF-8');
			}

			return $this->concat($splitNumber);
		}

    public function toString(float|int $number, int $decimals = 2, string $whole_str = '', string $decimal_str = ''): string
    {
        return $this->toMoney($number, $decimals, $whole_str, $decimal_str);
    }
	
    public function toInvoice(float $number, int $decimals = 2, string $currency = ''): string
	{
		$this->checkApocope();

		$number = number_format($number, $decimals, '.', '');

		$splitNumber = explode('.', $number);

		$splitNumber[0] = $this->wholeNumber($splitNumber[0]);

		if (!empty($splitNumber[1])) {
			$splitNumber[1] .= '/100 ';
		} else {
			$splitNumber[1] = '00/100 ';
		}

		return $this->concat($splitNumber) . mb_strtoupper($currency, 'UTF-8');
	}

	
    private function checkApocope(): void
    {
        if ($this->apocope === true) {
            $this->unidades[1] = 'UN ';
        }
    }

    private function wholeNumber(string $number): string
    {
        if ($number == '0') {
            $number = 'CERO ';
        } else {
            $number = $this->convertNumber($number);
        }

        return $number;
    }

    private function concat(array $splitNumber): string
    {
        return implode(' ' . mb_strtoupper($this->conector, 'UTF-8') . ' ', array_filter($splitNumber));
    }

    private function convertNumber(int $number): string
    {
        $converted = '';

        if (($number < 0) || !is_numeric($number)) {
            throw new ParseError('Invalid number');
        }

        $numberStrFill = str_pad($number, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);

        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLÓN ';
            } elseif (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', $this->convertGroup($millones));
            }
        }

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } elseif (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', $this->convertGroup($miles));
            }
        }

        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $this->apocope === true ? $converted .= 'UN ' : $converted .= 'UNO ';
            } elseif (intval($cientos) > 0) {
                $converted .= sprintf('%s ', $this->convertGroup($cientos));
            }
        }

        return trim($converted);
    }

    private function convertGroup(string $group): string
    {
        $output = '';

        if ($group == '100') {
            $output = 'CIEN ';
        } elseif ($group[0] !== '0') {
            $output = $this->centenas[$group[0] - 1];
        }

        $k = intval(substr($group, 1));

        if ($k <= 20) {
            $unidades = $this->unidades[$k];
        } else {
            if (($k > 30) && ($group[2] !== '0')) {
                $unidades = sprintf('%sY %s', $this->decenas[intval($group[1]) - 2], $this->unidades[intval($group[2])]);
            } else {
                $unidades = sprintf('%s%s', $this->decenas[intval($group[1]) - 2], $this->unidades[intval($group[2])]);
            }
        }

        $output .= array_key_exists(trim($unidades), $this->acentosExcepciones) ?
            $this->acentosExcepciones[trim($unidades)] : $unidades;

        return $output;
    }
}