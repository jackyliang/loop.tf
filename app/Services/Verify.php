<?php

namespace App\Services;

class Verify {
    // Class variables
    private $ourTeamURL;
    private $theirTeamURL;

    private $ourTeamHTML;
    private $theirTeamHTML;

    private $ourTeamPlayers = array();
    private $theirTeamPlayers;

    private $steamNameList = array();
    private $steamIDList = array();

    public function Verify($ourTeamURL, $theirTeamURL) {

        libxml_use_internal_errors(true);

        $this->ourTeamURL = $ourTeamURL;
        $this->theirTeamURL = $theirTeamURL;

        $this->ourTeamHTML = new DomDocument;
        $this->ourTeamHTML->loadHTMLFile($this->ourTeamURL);

        $xpath = new DomXPath($this->ourTeamHTML);

        /* Set HTTP response header to plain text for debugging output */
        header("Content-type: text/plain");

        $steamNameAndIDXPath = '//*[@id="wrapper"]//div[@class="col-md-12"]//h5/b';

        $steamNameAndIDs = $xpath->query($steamNameAndIDXPath);

        foreach ($steamNameAndIDs as $id => $node) {
            $steamName = "";
            $steamID = "";

            // Store Steam name first (which is the even-numbered item)
            // in the scraped list. Then store the Steam ID (which is
            // the odd-numbered item).
            if($id % 2 == 0 && $node->nodeValue !== '') {
                $steamName = $node->nodeValue;
            } else if ($id % 2 == 1 && $node->nodeValue !== '') {
                $steamID = $node->nodeValue;
            }

            // Add each Steam name onto our team's list
            array_push($this->steamNameList, $steamName);

            // Add each Steam ID onto our team's list
            array_push($this->steamIDList, $steamID);
        }

        // Combine Steam ID and Steam Name to our team's associative
        // list
        $this->ourTeamPlayers = array_combine(
            $this->steamNameList,
            $this->steamIDList
        );

        // Scrape their team site
        // Store Name -> Steam ID
    }

    public function getOurTeam(){
        return $this->ourTeamPlayers;
    }

    public function getOurTeamName(){

    }

    public function getTheirTeam(){

    }

    public function getTheirTeamName(){

    }

    public function getMisMatches(){

    }

}