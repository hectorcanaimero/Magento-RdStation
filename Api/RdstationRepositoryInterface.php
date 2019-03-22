<?php

namespace Vanguarda\RdStation\Api;
interface RdstationRepositoryInterface {
    
    public function save(\Vanguarda\RdStation\Api\Data\RdstationInterface $news);
    
    public function getById($newsId);
    
    public function delete(\Vanguarda\RdStation\Api\Data\RdstationInterface $news);
    
    public function deleteById($newsId);
}

?>