<?php

class ParseRozetka
{
    /**
     * Get source from rozetka.
     *
     * @return string.
     */
    public function getRozetka()
    {
        $curl = curl_init('http://hard.rozetka.com.ua/monitors/c80089/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * Grab links from rozetka.
     *
     * @return array.
     */
    public function getLinks()
    {
        $response = $this->getRozetka();
        preg_match_all(
            '/http:\/\/hard.rozetka.com.ua\/(\w{5,})\/(\w{7,})(\d{1,})/', $response, $links
        );

        return $links;
    }

    /**
     * Download pictures from links.
     * Create directory and save it.
     */
    public function getPictures()
    {
        $result = $this->getLinks();
        $array = array_unique($result[0]);
        $array = array_values($array);

        foreach ($array as $link) {
            echo '<b>.';
            $itemPicture = [];
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $link . '/');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($curl);

            preg_match_all(
                '/http:\/\/i1.rozetka.ua\/goods\/(\w{5,})\/(?!record)(\w{7,}).jpg/', $result, $itemPicture
            );
            curl_close($curl);

            $dirName = array_shift(array_values($itemPicture[2]));

            if(!is_dir($dirName)){
                mkdir($dirName);
            }

            $file = file_get_contents($itemPicture[0][0], 'r');
            file_put_contents(__DIR__ . '/' . $dirName . '/' . $dirName . '.jpg', $file);
        }
    }
}
