function afterResponse($data){
	var $response	=	jQuery.parseJSON($data);
	console.log($response);
	if($response.status==1)
	{
		$('#class_register').html($response.data);
		if($response.type==2){
			$('#medium_register').css('display','none');
			$('#medium_register').html($response.medium);
		}else{
			$('#medium_register').css('display','block');
			$('#medium_register').html($response.medium);
		}
		
	}
	 else{alert($response.data);$('#Register_gudaak_id').val('');}
}