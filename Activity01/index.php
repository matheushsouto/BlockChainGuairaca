<?php class ActivityBlockChain
{

    private $people = [
        'Chase',
        'Rennie',
        'Franklin',
        'Huynh',
        'England',
        'Lugo',
        'Rodrigues',
        'Betts',
        'Cummings',
        'Irwin',
        'Nixon',
        'Higgins',
        'Cook',
        'Ross',
        'Eaton',
        'Fountain'
    ];

    private $blockChain = [];

    function createWriteBlock($block, $source, $destiny, $hash, $hashPrevious)
    {
        $message =
            "Origem: " . $source.PHP_EOL .
            "Destino: " . $destiny.PHP_EOL .
            "Mensagem: Olá " . $destiny . '. ' . 'Meu nome é ' . $source.PHP_EOL .
            'Hash ' . $hash.PHP_EOL. 'Hash Anterior ' .$hashPrevious;

        file_put_contents("blocks/block-".$block.".txt", $message);
    }

    public function createBlockChain(){
        for ($index = 0; $index < count($this->people); $index++){
            $block = file_get_contents("blocks/block-".($index+1).".txt");
            if ($index > 0) {
                $blockPrevious = file_get_contents("blocks/block-" . (($index+1) - 1) . ".txt");
            }else{
                $blockPrevious = null;
            }
            $this->blockChain = [
                "Bloco" => $block,
                "Hash" => hash("sha256", $block),
                "Hash Anterior" => ($index > 0 ? hash("sha256", $blockPrevious) : null),
            ];
            $this->createWriteBlock(($index+1), $this->people[$index], ($index == (count($this->people)-1) ? $this->people[0] : $this->people[($index+1)]),hash("sha256", $block),hash("sha256", $blockPrevious));

        }
//        $this->validate($this->blockChain);
    }

    function validateBlockChain(array $blockChain)
    {

        for ($index = 0; $index < count($blockChain); $index++) {
            $hashPrevious = ($index > 0 ? hash("sha256", $blockChain[$index - 1]["Bloco"]) : null);
            $hash = hash("sha256", $blockChain[$index]["Bloco"]);

            if ($hashPrevious != $blockChain[$index]["Hash Anterior"]) {
                return [false, "Hash Previous Invalid Block: " . ($index + 1)];
            }
            if ($hash != $blockChain[$index]["Hash"]) {
                return [false, "Hash Invalid block: " . ($index + 1)];
            }

        }

        return [true, "Chain validada com sucesso"];
    }
}

$blockChain = new ActivityBlockChain();
$blockChain->createBlockChain();


