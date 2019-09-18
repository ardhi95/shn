<?php

	App::import('Component','TreeLabel');
	App::import('Component','TreeNode');

	class DecisionTreeComponent extends Component
	{
		var $tree;
		var $atribut 		= array();
		var $data_latih 	= array();
		var $kelas 			= array();
		var $gain 			= array(); 
		
		public function DecisionTreeComponent()
		{
		}

		public function setAtribut($arrayatribut = array()) { 
			$this->atribut = $arrayatribut;
			// pr($this->atribut);
			return $this->atribut;
		}

		public function getAtribut() { 
			return $this->atribut;
		}

		public function getTree() {
			return $this->tree;
		}

		public function getGain() {
			return $this->gain;
		}
		
		public function addDatalatih($arraydatalatih = array()) { 
			foreach ($arraydatalatih as $instance) { 
				$this->data_latih[] = $instance;
			}

			$this->kelas = $this->getKelas($this->data_latih);
			return $this->kelas;
		}

		public function getDatalatih() {
			return $this->data_latih;
		}

			public function hitungEntropy($data) { 
			$jumlah = array();
			foreach ($data as $set) { 
				if (!isset($jumlah[$set[1]])) 
					$jumlah[$set[1]] = 1; 
				else
					$jumlah[$set[1]]++; 
			}

			$entropy = 0;
			$total   = array_sum($jumlah); 
			foreach ($jumlah as $value) 
				$entropy += -($value / $total) * log($value / $total, 2); 

			return $entropy;
		}

		public function hitungGain($data, $kolom) { 
			$entropy = $this->hitungEntropy($data); 

			$jumlah = array();
			foreach ($data as $set) { 
				if (!isset($jumlah[$set[0][$kolom]]))  
					$jumlah[$set[0][$kolom]] = array(); 

				if (!isset($jumlah[$set[0][$kolom]][$set[1]]))   
					$jumlah[$set[0][$kolom]][$set[1]] = 0; 

				$jumlah[$set[0][$kolom]][$set[1]]++; 
			}

			$gain  = 0;
			$total = count($data); 
			foreach ($jumlah as $key => $value) { 
				$gain -= (array_sum($value) / $total) * $this->hitungEntropy(array_filter($data, function ($set) use ($kolom, $key) {
						return ($set[0][$kolom] == $key); 
					}
				));
			}

			return $entropy + $gain;
		}

		
		public function getUrutanGain($data_latih, $atribut) { 
			$gain = array();
			for ($i = 0; $i < count($atribut); $i++) { 
				$gain[$i] = $this->hitungGain($data_latih, $atribut[$i]); 
			}
			asort($gain);
			return $gain;
		}
		
		public function buatTree($data_latih, $target_atribut, $arrayatribut = array()) { 
			$kolom  = $target_atribut;
			$kelas = $this->getKelas($data_latih);
			// pr(count($kelas));
			if (count($kelas) === 1) { 
				return new TreeLabelComponent($kelas[0]);
			} elseif (count($arrayatribut) === 0) {
				$nilaidata = $this->getNilaidata($data_latih, $kolom); 
				$prob   = $this->hitungProb($data_latih, $kolom); 
				$node   = array(); 
				foreach ($nilaidata as $value) { 
					end($prob[$value]);  
					$label        = key($prob[$value]); 
					$node[$kolom." ".$value] = new TreeLabelComponent($label); 
				}

				return new TreeNodeComponent($node);
			} else {
				$nilaidata = $this->getNilaidata($data_latih, $kolom); 
				$node   = array(); 
				foreach ($nilaidata as $value) {
					$node[$kolom." ".$value] = $this->buatTree( 
						$this->getIsidataDari($data_latih, $kolom, $value),
						array($arrayatribut),
						$arrayatribut
					);
				}
				// pr($nilaidata);

				return new TreeNodeComponent($node);
			}
		}
		
		public function mulaiPelatihan() { 
			$this->gain = $this->getUrutanGain($this->data_latih, $this->atribut); 
			$indeksgain = array_keys($this->gain); 
			foreach ($indeksgain as $key => $value) { 
				$atribut_urut[] = $this->atribut[$value]; 
			}
			$this->tree = $this->buatTree( 
				$this->data_latih,
				array_pop($atribut_urut), 
				$atribut_urut
			);
			return $this->tree; 
		}

		// public function klasifikasi($instance = array()) { 
		// 	if ((count($instance) < count($this->atribut))) { 
		// 		throw new \BadFunctionCallException('Jumlah atribut pada instance untuk klasifikasi tidak cocok.');
		// 	}

		// 	if (!isset($this->gain)) { 
		// 		throw new \BadFunctionCallException('Harus dilakukan pelatihan dahulu sebelum klasifikasi.');
		// 	}

		// 	$route = array(); 
		// 	foreach($this->gain as $key => $gain){ 
		// 		$route[] = $this->atribut[$key]." ".$instance[$key]; 
		// 	}
		// 	return $this->transverseTree($this->tree, $route); //mengeluarkan tree hasil data uji
		// }


		// public function transverseTree($tree, $route) { 
		// 	pr($tree);
		// 	while($route){ 
		// 		if(is_a($tree, 'DecisionTree\TreeLabel')){ 
		// 			break;
		// 		}else{ 
		// 			try{ 
		// 				$tree = $tree->{array_pop($route)}; 
		// 			}catch(\Exception $e){ 

		// 			}
		// 		}
		// 	}
		// 	return $tree;
		// }

		public function getKelas($data_latih) { 
			$kelas = array();
			foreach ($data_latih as $set) 
				if (!in_array($set[1], $kelas))  
					$kelas[] = $set[1]; 

			return $kelas;
		}

		public function getNilaidata($data_latih, $kolom) { 
			$nilaidata = array();
			foreach ($data_latih as $set) 
			if(isset($set[0][$kolom])){ 
				if (!in_array($set[0][$kolom], $nilaidata)) { 
					$nilaidata[] = $set[0][$kolom]; 
				}
			}
			return $nilaidata;
		}

		public function getIsidataDari($data, $kolom, $nilaidata, $kelas = null) { 
			return array_filter($data, function ($input) use ($kolom, $nilaidata, $kelas) { 
				if ($kelas == null) { 
					return ($input[0][$kolom] == $nilaidata); 
				} else {
					return (($input[0][$kolom] == $nilaidata) and ($input[1] == $kelas)); 
				}
			});
		}

		public function hitungProb($data, $kolom) { 
			$nilaidata  = $this->getNilaidata($data, $kolom); 
			$kelas = $this->getKelas($data);
			$prob    = array(); 
			foreach ($nilaidata as $value) { 
				$prob[$value] = array(); 
				foreach ($this->getIsidataDari($data, $kolom, $value) as $set) { 
					if(!isset($prob[$value][$set[1]]))
						$prob[$value][$set[1]] = 1; 
					else
						$prob[$value][$set[1]]++;
				}
				foreach ($kelas as $out) { 
					$total = count($this->getIsidataDari($data, $kolom, $value, $out)); 
					if ($total != 0)   
						$prob[$value][$out] = $prob[$value][$out] / $total;
				}
				asort($prob[$value]);
			}

			return $prob;

		}
	}
?>