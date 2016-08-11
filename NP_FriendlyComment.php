<?php
class NP_FriendlyComment extends NucleusPlugin {
    function getName()        { return 'Friendly Comment';}
    function getAuthor()      { return 'Lord Matt';}
    function getURL()         { return 'http://lordmatt.co.uk';}
    function getVersion()     { return '1.0';}
    function getDescription() { return 'Stops data being brashly shown (such as email adresses).';}
    function getEventList()   { return array('PreComment');}
    
    function event_PreComment(&$data){
        global $manager;
        
        $pos = strpos($data['comment']['userlinkraw'], '@');
        if ($pos === false) return;
        
        $created = false;
        $url = '';
        $params = array('itemid'=>$data['comment']['itemid'], 'blogid'=>$data['comment']['blogid']);
        $manager->notify(
            'GenerateURL',
            array(
            'type' => 'item',
            'params' => $params,
            'completed' => &$created,
            'url' => &$url
            )
        );
        $data['comment']['userlinkraw'] = $url . '#' . $data['commentid'];
    }
}