<?php

namespace frontend\widgets;

class SocialLoginWidget extends \nodge\eauth\Widget
{
    
    	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run()
	{
		echo $this->render('widget', array(
			'id' => $this->getId(),
			'services' => $this->services,
			'action' => $this->action,
			'popup' => $this->popup,
			'assetBundle' => $this->assetBundle,
		));
	}
}