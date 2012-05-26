<?php
class Common_Interceptor_Interview extends Anole_Dispatcher_Interceptor_Abstract {
	
    public function intercept(Anole_Dispatcher_ActionInvocation $invocation){
    	$action = $invocation->getAction();
        if(!$action instanceof Anole_Dispatcher_Action_Interface_ModelDriven){
            self::warn('Action hasnot method:wiredModel,no anything to do,skip.', __METHOD__);
            return $invocation->invoke();
        }
        $action_class = $invocation->getActionClass();
        $method = $invocation->getMethod();
    	$review = Anole_Config::get('review.'.$action_class);
    	if(empty($review)){
    		self::warn('Review Config file is NULL,nothing to do,skip.',__METHOD__);
    		return $invocation->invoke();
    	}
    	$method_list = array_values($review);
    	if(in_array($method,$method_list)){
    		$report = Anole_Config::get('review.output_report');
    		$adminor = 'ssy';
    		$msg = date('y-m-d H:i:s')." $adminor execute the method[$method] of the class[$action_class]\n";
    		error_log($msg,3,$report);
    	}
    	$invocation->invoke();
    }
    
}
?>