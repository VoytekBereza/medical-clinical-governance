<?php
	class ListItemList
	{
		private $m_lilListItemList;
				
		public function getCount()
		{
			return count($this->m_lilListItemList);
		}
		
		public function getAt($nIndex)
		{
			if ($nIndex < 0 ||
				$nIndex >= count($this->m_lilListItemList))
			{
				throw new Exception('Array index out of bounds');
			}
				
			return $this->m_lilListItemList[$nIndex];
		}
		
		public function add($szName, $szValue, $boIsSelected)
		{
			$liListItem = new ListItem($szName, $szValue, $boIsSelected);

			$this->m_lilListItemList[] = $liListItem;
		}

		public function toString()
		{
			$szReturnString = "";

			for ($nCount = 0; $nCount < count($this->m_lilListItemList); $nCount++)
			{
				$liListItem = $this->m_lilListItemList[$nCount];
				
				$szReturnString = $szReturnString."<option";

				if ($liListItem->getValue() != null &&
					$liListItem->getValue() != "")
				{
					$szReturnString = $szReturnString." value=\"".$liListItem->getValue()."\"";
				}

				if ($liListItem->getIsSelected() == true)
				{
					$szReturnString = $szReturnString." selected=\"selected\"";	
				}

				$szReturnString = $szReturnString.">".$liListItem->getName()."</option>\n";
			}

			return ($szReturnString);
		}

		//constructor
		public function __construct()
		{
	        $this->m_lilListItemList = array();
		}
	}

	class ListItem
	{
		private $m_szName;
	   	private $m_szValue;
	    private $m_boIsSelected;
	    
	    //public properties
	    public function getName()
	    {
	    	return $this->m_szName;
	    }
	    
	    public function getValue()
	    {
	    	return $this->m_szValue;
	    }
	   
	    public function getIsSelected()
	    {
	    	return $this->m_boIsSelected;
	    }
	   	    
	    //constructor
	    public function __construct($szName, $szValue, $boIsSelected)
	    {
	    	$this->m_szName = $szName;
	    	$this->m_szValue = $szValue;
	    	$this->m_boIsSelected = $boIsSelected;
	    }
	}

	class PaymentFormHelper
	{
		public static function getSiteSecureBaseURL()
		{
            $szReturnString = "";
            $szPortString = "";
            $szProtocolString = "";

            if ($_SERVER["HTTPS"] == "on")
            {
                $szProtocolString = "https://";
                if ($_SERVER["SERVER_PORT"] != 443)
                {
                    $szPortString = ":" . $_SERVER["SERVER_PORT"];
                }
            }
            else
            {
                $szProtocolString = "http://";
                if ($_SERVER["SERVER_PORT"] != 80)
                {
                    $szPortString = ":" . $_SERVER["SERVER_PORT"];
                }
            }

            $szReturnString = $szProtocolString . $_SERVER["SERVER_NAME"] . $szPortString . $_SERVER["SCRIPT_NAME"];

            $boFinished = false;
            $LoopIndex = strlen($szReturnString) - 1;

            while ($boFinished == false && $LoopIndex >= 0)
            {
                if ($szReturnString[$LoopIndex] == "/")
                {
                    $boFinished = true;
                    $szReturnString = substr($szReturnString, 0, $LoopIndex + 1);
                }
                $LoopIndex--;
                ;
            }

            return ($szReturnString);
		}
		public static function createExpiryDateMonthListItemList($ExpiryDateMonth)
		{
			$lilExpiryDateMonthList = new ListItemList();

			for ($LoopIndex = 1; $LoopIndex <= 12; $LoopIndex++)
			{
				$DisplayMonth = $LoopIndex;
				if ($LoopIndex < 10)
				{
					$DisplayMonth = "0".$LoopIndex;
				}
				if ($ExpiryDateMonth != "" && $ExpiryDateMonth == $LoopIndex)
				{
					$lilExpiryDateMonthList->add($DisplayMonth, $DisplayMonth, true);
				}
				else
				{
					$lilExpiryDateMonthList->add($DisplayMonth, $DisplayMonth, false);
				}
			}

			return ($lilExpiryDateMonthList);
		}
		public static function createExpiryDateYearListItemList($ExpiryDateYear)
		{
			$ThisYear = date("Y");
			$ThisYearPlusTen = $ThisYear + 10;
		
			$lilExpiryDateYearList = new ListItemList();

			for ($LoopIndex = $ThisYear; $LoopIndex <= $ThisYearPlusTen; $LoopIndex++)
			{
				$ShortYear=substr($LoopIndex, strlen($LoopIndex)-2, 2);
				if ($ExpiryDateYear != "" &&
				    $ExpiryDateYear == $ShortYear)
				{
					$lilExpiryDateYearList->add($LoopIndex, $ShortYear, true);
				}
				else
				{
					$lilExpiryDateYearList->add($LoopIndex, $ShortYear, false);
				}
			}

			return ($lilExpiryDateYearList);
		}
		public static function createStartDateMonthListItemList($StartDateMonth)
		{
			$lilStartDateMonthList = new ListItemList();

			for ($LoopIndex = 1; $LoopIndex <= 12; $LoopIndex++)
			{
				$DisplayMonth = $LoopIndex;
				if ($LoopIndex < 10)
				{
					$DisplayMonth = "0".$LoopIndex;
				}
				if ($StartDateMonth != "" &&
				    $StartDateMonth == $LoopIndex)
				{
					$lilStartDateMonthList->add($DisplayMonth, $DisplayMonth, true);
				}
				else
				{
					$lilStartDateMonthList->add($DisplayMonth, $DisplayMonth, false);
				}
			}

			return ($lilStartDateMonthList);
		}
		public static function createStartDateYearListItemList($StartDateYear)
		{
			$ThisYear = date("Y");

			$lilStartDateYearList = new ListItemList();

			for ($LoopIndex = 2000; $LoopIndex <= $ThisYear; $LoopIndex++)
		   	{
		   		$ShortYear=substr($LoopIndex, strlen($LoopIndex)-2, 2);
		   		if ($StartDateYear != "" &&
		   	    	$StartDateYear == $ShortYear)
		   		{
					$lilStartDateYearList->add($LoopIndex, $ShortYear, true);
				}
				else
				{
					$lilStartDateYearList->add($LoopIndex, $ShortYear, false);
				}
			}
			
			return ($lilStartDateYearList);		
		}
		public static function createISOCountryListItemList($CountryShort, $iclISOCountryList)
		{
			$lilISOCountryList = new ListItemList();

			$FirstZeroPriorityGroup = true;
			for ($LoopIndex = 0; $LoopIndex < $iclISOCountryList->getCount()-1; $LoopIndex++)
			{
				if ($iclISOCountryList->getAt($LoopIndex)->getListPriority() == 0 &&
					$FirstZeroPriorityGroup == true)
				{
					$lilISOCountryList->add("--------------------", "-1", false);
					$FirstZeroPriorityGroup = false;
				} 

				if ($CountryShort != "" &&
					$CountryShort != -1 &&
					$CountryShort == $iclISOCountryList->getAt($LoopIndex)->getCountryShort3())
				{
					$lilISOCountryList->add($iclISOCountryList->getAt($LoopIndex)->getCountryName(), $iclISOCountryList->getAt($LoopIndex)->getCountryShort3(), true);
				}
				else
				{
					$lilISOCountryList->add($iclISOCountryList->getAt($LoopIndex)->getCountryName(), $iclISOCountryList->getAt($LoopIndex)->getCountryShort3(), false);
				}
			}

			return ($lilISOCountryList);
		}
        public static function calculateHashDigest($szInputString)
        {
            $hashDigest = md5($szInputString);

            return ($hashDigest);
        }
        public static function generateStringToHash($szAmount, 
                               			            $szCurrencyShort, 
                                        			$szOrderID,
		                                            $szOrderDescription,
         		                                    $szSecretKey)
        {
			$szReturnString = "Amount=".$szAmount."&CurrencyShort=".$szCurrencyShort."&OrderID=".$szOrderID."&OrderDescription=".$szOrderDescription."&SecretKey=".$szSecretKey;

            return ($szReturnString);
        }
		public static function checkIntegrityOfIncomingVariables($ivsIncomingVariableSource, $aVariables, $szHash, $szSecretKey)
		{
			$boReturnValue = false;
			$szStringToHash = null;
			$szCalculatedHash = null;

			switch ($ivsIncomingVariableSource)
			{
				case "SHOPPING_CART_CHECKOUT":
                    $szStringToHash = self::generateStringToHash($aVariables["Amount"],
                        $aVariables["CurrencyShort"],
                        $aVariables["OrderID"],
                        $aVariables["OrderDescription"],
                        $szSecretKey);
					break;
				case "PAYMENT_FORM_POSTBACK":
                    $szStringToHash = self::generateStringToHash($aVariables["Amount"],
                        $aVariables["CurrencyShort"],
                        $aVariables["OrderID"],
                        $aVariables["OrderDescription"],
                        $szSecretKey);
					break;
				case "THREE_D_SECURE":
                    $szStringToHash = self::generateStringToHash2($aVariables["PaRES"],
                        $aVariables["CrossReference"],
                        $szSecretKey);
					break;

			}
			$szCalculatedHash = self::calculateHashDigest($szStringToHash);
			
			if ($szCalculatedHash == $szHash)
			{
				$boReturnValue = true;
			}

			return ($boReturnValue);
		}
        public static function generateStringToHash2($szPaRES,
                               			             $szCrossReference,
                                        			 $szSecretKey)
        {
			$szReturnString = "PaRES=".$szPaRES."&CrossReference=".$szCrossReference."&SecretKey=".$szSecretKey;
        }

        // This is a "hook" function that is run when the results of the transaction are
        // known. This will be run is 2 places:
        // 1) After the initial CardDetailsTransaction
        // 2) After the ThreeDSecureAuthentication transaction (if 3DS was required)
        //
        // IMPORTANT: in case 1) the unique key is set to be the OrderID, and this will allow
        // your system to lookup the transaction (in your database) if need be, so you need to ensure
        // that your orders are reference-able by their order ids
        //
        // Also, in case 2) the order id field is not available, so the cross reference of the
        // previous "3DS authentication required" transaction is used as the unique key for
        // the transaction. In order to get this working, you must ensure that when a transaction
        // is set to "3DS auth required" (i.e. the status code is 3), that you update that transaction
        // so that it can be referenced by the cross refernce of the "3DS required" response
        public static function reportTransactionResults($szTransactionUniqueKey, $nStatusCode, $szMessage, $szCrossReference)
        {
            if ($nStatusCode == 3)
            {
                // you must update the transaction with the szCrossReference field, so that when
                // this function is called after the 3DS authentication is done, the transaction
                // is referenceable by that cross reference - as the subsequent post-3DS call to this
                // function will use that cross reference as the transaction's TransactionUniqueKey
            }
        }
    }
?>