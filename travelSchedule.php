<?php
class test
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function travelSchedule($params) {
        // so far base on my expectation out database table name will be "travelTicket" ,
        // and inside will have those column "time,seat,gate,remark,type,fromLocation, toLocation"
        $db = $this->db;
        $currentLocation = $params['currentLocation'];
        $currentTime     = $params['currentTime'];

        if($currentLocation==""){
            return array('status' => "false", 'message' =>"please enter your current location");
        }

        if($currentTime==""){
            return array('status' => "false", 'message' =>"please enter your current time");
        }
        
        $db->where('time', $currentTime, ">");
        $db->orderBy('time', 'ASC');
        $travel = $db->get("travelTicket");

        $totalTicket = count($travel);

        if($totalTicket <= 0){
            return array('code' => 1, 'message' =>"You no have any incoming ticket");
        }else{
            foreach($travel){
                $type         = $travel['type'];
                $gate         = $travel['gate'];
                $seat         = $travel['seat'] ? $travel['seat'] : "No Assign";
                $time         = $travel['time'];
                $fromLocation = $travel['fromLocation'];
                $toLocation   = $travel['toLocation'];
                $remark       = $travel['remark'];

                $msg = "Type :".$type."\nGate :".$gate."\nSeat :".$seat."\nTime :".$time."\nFrom :".$fromLocation."\nTo :".$toLocation."\nRemark :".$remark."\n";

                $data[] = $msg;
            }
        }
        
        $returnData["Total Incomming Ticket"] = $totalTicket;
        $returnData["All Ticket Details"]     = $data;

        return array('status' => 'success', 'data' => $returnData);
    }
}

