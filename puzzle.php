<?php

/**
 * @author Anuj Kumar <anujrajput25@yahoo.com>
 */
class Puzzle
{
    /**
     * Class Puzzle
     *
     * Accepts the input file name and process it accordingly
     *
     * @var $fileName
     */
    public $fileName;

    function __construct($fileData)
    {
        $this->fileName = $fileData;
    }

    /**
     * function allocate wine to person
     *
     * Output a TSV file that provides the aggregate of total wines sold with desired TSV file
     *
     */
    public function allocateWines()
    {
        try {
            $wineWishList = [];
            $wineList = [];
            $totalWineSold = 0;
            $desiredList = [];
            $file = fopen($this->fileName, "r");

            //read file till the end
            while (($line = fgets($file)) !== false) {
                $name_and_wine = explode("\t", $line);
                $name = trim($name_and_wine[0]);
                $wine = trim($name_and_wine[1]);
                if (!array_key_exists($wine, $wineWishList)) {
                    $wineWishList[$wine] = [];
                }
                $wineWishList[$wine][] = $name; //wine wishlist of person
                $wineList[] = $wine;
            }
            fclose($file);

            //fetch unique wines
            $wineList = array_unique($wineList);

            foreach ($wineList as $key => $wine) {
                $counter = 0;
                while ($counter < 10) {
                    $person = $wineWishList[$wine][0];
                    if (!array_key_exists($person, $desiredList)) {
                        $desiredList[$person] = [];
                    }
                    if (count($desiredList[$person]) < 3) {
                        $desiredList[$person][] = $wine;
                        $totalWineSold++;
                        break;
                    }
                    $counter++;
                }
            }

            $fh = fopen("desiredList.txt", "w");    //output file name
            fwrite($fh, "Total number of wines bottles sold : " . $totalWineSold . "\n");
            foreach (array_keys($desiredList) as $key => $person) {
                foreach ($desiredList[$person] as $key => $wine) {
                    fwrite($fh, $person . " " . $wine . "\n");
                }
            }
            fclose($fh);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die;
        }

    }
}

$puzzle = new Puzzle("person_wine_3.txt");
$puzzle->allocateWines();
echo "Script Successfully ended";
?>
