<?php
//accessing external files
require_once ("TPG_Common.php");
require_once ("SOAP.php");

/*****************/
/* Input classes */
/*****************/
class RequestGatewayEntryPoint extends GatewayEntryPoint
{
	/**
	 * @var int
	 */
	private $m_nRetryAttempts;

	/**
	 * @return int
	 */
	public function getRetryAttempts()
	{
		return $this -> m_nRetryAttempts;
	}

	/**
	 * @param string $szEntryPointURL
	 * @param int    $nMetric
	 * @param int    $nRetryAttempts
	 */
	public function __construct($szEntryPointURL, $nMetric, $nRetryAttempts)
	{
		//do NOT forget to call the parent constructor too
		//parent::GatewayEntryPoint($szEntryPointURL, $nMetric);
		GatewayEntryPoint::__construct($szEntryPointURL, $nMetric);

		$this -> m_nRetryAttempts = $nRetryAttempts;
	}

}
class RequestGatewayEntryPointList
{
	/**
	 * @var RequestGatewayEntryPoint[]
	 */
	private $m_lrgepRequestGatewayEntryPoint;

	/**
	 * @param  int                      $nIndex
	 * @return RequestGatewayEntryPoint
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lrgepRequestGatewayEntryPoint))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_lrgepRequestGatewayEntryPoint[$nIndex];
	}
	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lrgepRequestGatewayEntryPoint);
	}
	/**
	 * @param string $ComparerClassName
	 * @param string $ComparerMethodName
	 */
	public function sort($ComparerClassName, $ComparerMethodName)
	{
		usort($this -> m_lrgepRequestGatewayEntryPoint, array(
			"$ComparerClassName",
			"$ComparerMethodName"
		));
	}
	/**
	 * @param string $EntryPointURL
	 * @param int    $nMetric
	 * @param int    $nRetryAttempts
	 */
	public function add($EntryPointURL, $nMetric, $nRetryAttempts)
	{
		array_push($this -> m_lrgepRequestGatewayEntryPoint, new RequestGatewayEntryPoint($EntryPointURL, $nMetric, $nRetryAttempts));
	}

	//constructor
	public function __construct()
	{
		$this -> m_lrgepRequestGatewayEntryPoint = array();
	}

}
class GenericVariable
{
	/**
	 * @var string
	 */
	private $m_szName;
	/**
	 * @var string
	 */
	private $m_szValue;

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this -> m_szName;
	}
	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this -> m_szName = $name;
	}
	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this -> m_szValue;
	}
	/**
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this -> m_szValue = $value;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szName = "";
		$this -> m_szValue = "";
	}

}
class GenericVariableList
{
	/**
	 * @var GenericVariable[]
	 */
	private $m_lgvGenericVariableList;

	/**
	 * @param  int|string      $intOrStringValue
	 * @return GenericVariable
	 * @throws Exception
	 */
	public function getAt($intOrStringValue)
	{
		$nCount = 0;
		$boFound = false;
		$gvGenericVariable = null;

		if (is_int($intOrStringValue))
		{
			if ($intOrStringValue < 0 || $intOrStringValue >= count($this -> m_lgvGenericVariableList))
			{
				throw new Exception("Array index out of bounds");
			}

			return $this -> m_lgvGenericVariableList[$intOrStringValue];
		}
		elseif (is_string($intOrStringValue))
		{
			if ($intOrStringValue == null || $intOrStringValue == "")
			{
				return (null);
			}

			while (!$boFound && $nCount < count($this -> m_lgvGenericVariableList))
			{
				if (strtoupper($this -> m_lgvGenericVariableList[$nCount] -> getName()) == strtoupper($intOrStringValue))
				{
					$gvGenericVariable = $this -> m_lgvGenericVariableList[$nCount];
					$boFound = true;
				}
				$nCount++;
			}

			return $gvGenericVariable;
		}
		else
		{
			throw new Exception("Invalid parameter type:$intOrStringValue");
		}
	}
	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lgvGenericVariableList);
	}
	/**
	 * @param string $szName
	 * @param string $szValue
	 */
	public function add($szName, $szValue)
	{
		if ($szName != null && $szName != "")
		{
			$genericVariable = new GenericVariable();
			$genericVariable -> setName($szName);
			$genericVariable -> setValue($szValue);
			array_push($this -> m_lgvGenericVariableList, $genericVariable);
		}
	}

	//constructor
	public function __construct()
	{
		$this -> m_lgvGenericVariableList = array();
	}

}
class CustomerDetails
{
	/**
	 * @var BillingAddress
	 */
	private $m_adBillingAddress;
	/**
	 * @var PrimaryAccountDetails
	 */
	private $m_padPrimaryAccountDetails;
	/**
	 * @var string
	 */
	private $m_szEmailAddress;
	/**
	 * @var string
	 */
	private $m_szPhoneNumber;
	/**
	 * @var string
	 */
	private $m_szCustomerIPAddress;

	/**
	 * @return BillingAddress
	 */
	public function getBillingAddress()
	{
		return $this -> m_adBillingAddress;
	}
	/**
	 * @return PrimaryAccountDetails
	 */
	public function getPrimaryAccountDetails()
	{
		return $this -> m_padPrimaryAccountDetails;
	}
	/**
	 * @return string
	 */
	public function getEmailAddress()
	{
		return $this -> m_szEmailAddress;
	}
	/**
	 * @param string $emailAddress
	 */
	public function setEmailAddress($emailAddress)
	{
		$this -> m_szEmailAddress = $emailAddress;
	}
	/**
	 * @return string
	 */
	public function getPhoneNumber()
	{
		return $this -> m_szPhoneNumber;
	}
	/**
	 * @param string $phoneNumber
	 */
	public function setPhoneNumber($phoneNumber)
	{
		$this -> m_szPhoneNumber = $phoneNumber;
	}
	/**
	 * @return string
	 */
	public function getCustomerIPAddress()
	{
		return $this -> m_szCustomerIPAddress;
	}
	/**
	 * @param string $IPAddress
	 */
	public function setCustomerIPAddress($IPAddress)
	{
		$this -> m_szCustomerIPAddress = $IPAddress;
	}

	//constructor
	public function __construct()
	{
		$this -> m_adBillingAddress = new BillingAddress();
		$this -> m_padPrimaryAccountDetails = new PrimaryAccountDetails();
		$this -> m_szEmailAddress = "";
		$this -> m_szPhoneNumber = "";
		$this -> m_szCustomerIPAddress = "";
	}

}
class BillingAddress
{
	/**
	 * @var string
	 */
	private $m_szAddress1;
	/**
	 * @var string
	 */
	private $m_szAddress2;
	/**
	 * @var string
	 */
	private $m_szAddress3;
	/**
	 * @var string
	 */
	private $m_szAddress4;
	/**
	 * @var string
	 */
	private $m_szCity;
	/**
	 * @var string
	 */
	private $m_szState;
	/**
	 * @var string
	 */
	private $m_szPostCode;
	/**
	 * @var NullableInt
	 */
	private $m_nCountryCode;

	/**
	 * @return string
	 */
	public function getAddress1()
	{
		return $this -> m_szAddress1;
	}
	/**
	 * @param string $address1
	 */
	public function setAddress1($address1)
	{
		$this -> m_szAddress1 = $address1;
	}
	/**
	 * @return string
	 */
	public function getAddress2()
	{
		return $this -> m_szAddress2;
	}
	/**
	 * @param string $address2
	 */
	public function setAddress2($address2)
	{
		$this -> m_szAddress2 = $address2;
	}
	/**
	 * @return string
	 */
	public function getAddress3()
	{
		return $this -> m_szAddress3;
	}
	/**
	 * @param string $address3
	 */
	public function setAddress3($address3)
	{
		$this -> m_szAddress3 = $address3;
	}
	/**
	 * @return string
	 */
	public function getAddress4()
	{
		return $this -> m_szAddress4;
	}
	/**
	 * @param string $address4
	 */
	public function setAddress4($address4)
	{
		$this -> m_szAddress4 = $address4;
	}
	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this -> m_szCity;
	}
	/**
	 * @param string $city
	 */
	public function setCity($city)
	{
		$this -> m_szCity = $city;
	}
	/**
	 * @return string
	 */
	public function getState()
	{
		return $this -> m_szState;
	}
	/**
	 * @param string $state
	 */
	public function setState($state)
	{
		$this -> m_szState = $state;
	}
	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this -> m_szPostCode;
	}
	/**
	 * @param string $postCode
	 */
	public function setPostCode($postCode)
	{
		$this -> m_szPostCode = $postCode;
	}
	/**
	 * @return NullableInt
	 */
	public function getCountryCode()
	{
		return $this -> m_nCountryCode;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szAddress1 = "";
		$this -> m_szAddress2 = "";
		$this -> m_szAddress3 = "";
		$this -> m_szAddress4 = "";
		$this -> m_szCity = "";
		$this -> m_szState = "";
		$this -> m_szPostCode = "";
		$this -> m_nCountryCode = new NullableInt();
	}

}
class AddressDetails
{
	/**
	 * @var string
	 */
	private $m_szAddress1;
	/**
	 * @var string
	 */
	private $m_szAddress2;
	/**
	 * @var string
	 */
	private $m_szAddress3;
	/**
	 * @var string
	 */
	private $m_szAddress4;
	/**
	 * @var string
	 */
	private $m_szCity;
	/**
	 * @var string
	 */
	private $m_szState;
	/**
	 * @var string
	 */
	private $m_szPostCode;
	/**
	 * @var NullableInt
	 */
	private $m_nCountryCode;

	/**
	 * @return string
	 */
	public function getAddress1()
	{
		return $this -> m_szAddress1;
	}
	/**
	 * @param string $address1
	 */
	public function setAddress1($address1)
	{
		$this -> m_szAddress1 = $address1;
	}
	/**
	 * @return string
	 */
	public function getAddress2()
	{
		return $this -> m_szAddress2;
	}
	/**
	 * @param string $address2
	 */
	public function setAddress2($address2)
	{
		$this -> m_szAddress2 = $address2;
	}
	/**
	 * @return string
	 */
	public function getAddress3()
	{
		return $this -> m_szAddress3;
	}
	/**
	 * @param string $address3
	 */
	public function setAddress3($address3)
	{
		$this -> m_szAddress3 = $address3;
	}
	/**
	 * @return string
	 */
	public function getAddress4()
	{
		return $this -> m_szAddress4;
	}
	/**
	 * @param string $address4
	 */
	public function setAddress4($address4)
	{
		$this -> m_szAddress4 = $address4;
	}
	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this -> m_szCity;
	}
	/**
	 * @param string $city
	 */
	public function setCity($city)
	{
		$this -> m_szCity = $city;
	}
	/**
	 * @return string
	 */
	public function getState()
	{
		return $this -> m_szState;
	}
	/**
	 * @param string $state
	 */
	public function setState($state)
	{
		$this -> m_szState = $state;
	}
	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this -> m_szPostCode;
	}
	/**
	 * @param string $postCode
	 */
	public function setPostCode($postCode)
	{
		$this -> m_szPostCode = $postCode;
	}
	/**
	 * @return NullableInt
	 */
	public function getCountryCode()
	{
		return $this -> m_nCountryCode;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szAddress1 = "";
		$this -> m_szAddress2 = "";
		$this -> m_szAddress3 = "";
		$this -> m_szAddress4 = "";
		$this -> m_szCity = "";
		$this -> m_szState = "";
		$this -> m_szPostCode = "";
		$this -> m_nCountryCode = new NullableInt();
	}

}
class PrimaryAccountDetails
{
	/**
	 * @var AddressDetails
	 */
	private $m_adAddressDetails;
	/**
	 * @var string
	 */
	private $m_szName;
	/**
	 * @var string
	 */
	private $m_szAccountNumber;
	/**
	 * @var string
	 */
	private $m_szDateOfBirth;

	/**
	 * @return AddressDetails
	 */
	public function getAddressDetails()
	{
		return $this->m_adAddressDetails;
	}
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->m_szName;
	}
	/**
	 * @param string $m_szName
	 */
	public function setName($m_szName)
	{
		$this->m_szName = $m_szName;
	}
	/**
	 * @return string
	 */
	public function getAccountNumber()
	{
		return $this->m_szAccountNumber;
	}
	/**
	 * @param string $m_szAccountNumber
	 */
	public function setAccountNumber($m_szAccountNumber)
	{
		$this->m_szAccountNumber = $m_szAccountNumber;
	}
	/**
	 * @return string
	 */
	public function getDateOfBirth()
	{
		return $this->m_szDateOfBirth;
	}
	/**
	 * @param string $m_szDateOfBirth
	 */
	public function setDateOfBirth($m_szDateOfBirth)
	{
		$this->m_szDateOfBirth = $m_szDateOfBirth;
	}

	//constructor
	public function __construct()
	{
		$this->m_adAddressDetails = new AddressDetails();
		$this->m_szName = "";
		$this->m_szAccountNumber = "";
		$this->m_szDateOfBirth = "";
	}
}
abstract class CreditCardDate
{
	/**
	 * @var NullableInt
	 */
	private $m_nMonth;
	/**
	 * @var NullableInt
	 */
	private $m_nYear;

	/**
	 * @return NullableInt
	 */
	public function getMonth()
	{
		return $this -> m_nMonth;
	}
	/**
	 * @return NullableInt
	 */
	public function getYear()
	{
		return $this -> m_nYear;
	}

	//constructor
	public function __construct()
	{
		$this -> m_nMonth = new NullableInt();
		$this -> m_nYear = new NullableInt();
	}

}
class ExpiryDate extends CreditCardDate
{
	public function __construct()
	{
		parent::__construct();
	}

}
class StartDate extends CreditCardDate
{
	public function __construct()
	{
		parent::__construct();
	}

}
class CardDetails
{
	/**
	 * @var string
	 */
	private $m_szCardName;
	/**
	 * @var string
	 */
	private $m_szCardNumber;
	/**
	 * @var ExpiryDate
	 */
	private $m_edExpiryDate;
	/**
	 * @var StartDate
	 */
	private $m_sdStartDate;
	/**
	 * @var string
	 */
	private $m_szIssueNumber;
	/**
	 * @var string
	 */
	private $m_szCV2;

	/**
	 * @return string
	 */
	public function getCardName()
	{
		return $this -> m_szCardName;
	}
	/**
	 * @param string $cardName
	 */
	public function setCardName($cardName)
	{
		$this -> m_szCardName = $cardName;
	}
	/**
	 * @return string
	 */
	public function getCardNumber()
	{
		return $this -> m_szCardNumber;
	}
	/**
	 * @param string $cardNumber
	 */
	public function setCardNumber($cardNumber)
	{
		$this -> m_szCardNumber = $cardNumber;
	}
	/**
	 * @return ExpiryDate
	 */
	public function getExpiryDate()
	{
		return $this -> m_edExpiryDate;
	}
	/**
	 * @return StartDate
	 */
	public function getStartDate()
	{
		return $this -> m_sdStartDate;
	}
	/**
	 * @return string
	 */
	public function getIssueNumber()
	{
		return $this -> m_szIssueNumber;
	}
	/**
	 * @param string $issueNumber
	 */
	public function setIssueNumber($issueNumber)
	{
		$this -> m_szIssueNumber = $issueNumber;
	}
	/**
	 * @return string
	 */
	public function getCV2()
	{
		return $this -> m_szCV2;
	}
	/**
	 * @param string $cv2
	 */
	public function setCV2($cv2)
	{
		$this -> m_szCV2 = $cv2;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szCardName = "";
		$this -> m_szCardNumber = "";
		$this -> m_edExpiryDate = new ExpiryDate();
		$this -> m_sdStartDate = new StartDate();
		$this -> m_szIssueNumber = "";
		$this -> m_szCV2 = "";
	}

}
class OverrideCardDetails extends CardDetails
{
	public function __construct()
	{
		parent::__construct();
	}

}
class MerchantAuthentication
{
	/**
	 * @var string
	 */
	private $m_szMerchantID;
	/**
	 * @var string
	 */
	private $m_szPassword;

	/**
	 * @return string
	 */
	public function getMerchantID()
	{
		return $this -> m_szMerchantID;
	}
	/**
	 * @param string $merchantID
	 */
	public function setMerchantID($merchantID)
	{
		$this -> m_szMerchantID = $merchantID;
	}
	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this -> m_szPassword;
	}
	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this -> m_szPassword = $password;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szMerchantID = "";
		$this -> m_szPassword = "";
	}

}
class MessageDetails
{
	/**
	 * @var string
	 */
	private $m_szTransactionType;
	/**
	 * @var NullableBool
	 */
	private $m_boNewTransaction;
	/**
	 * @var string
	 */
	private $m_szCrossReference;
	/**
	 * @var string
	 */
	private $m_szClientReference;
	/**
	 * @var string
	 */
	private $m_szPreviousClientReference;

	/**
	 * @return string
	 */
	public function getTransactionType()
	{
		return $this -> m_szTransactionType;
	}
	/**
	 * @param string $transactionType
	 */
	public function setTransactionType($transactionType)
	{
		$this -> m_szTransactionType = $transactionType;
	}
	/**
	 * @return NullableBool
	 */
	public function getNewTransaction()
	{
		return $this -> m_boNewTransaction;
	}
	/**
	 * @return string
	 */
	public function getCrossReference()
	{
		return $this -> m_szCrossReference;
	}
	/**
	 * @param string $crossReference
	 */
	public function setCrossReference($crossReference)
	{
		$this -> m_szCrossReference = $crossReference;
	}
	/**
	 * @return string
	 */
	public function getClientReference()
	{
		return $this -> m_szClientReference;
	}
	/**
	 * @param string $clientReference
	 */
	public function setClientReference($clientReference)
	{
		$this -> m_szClientReference = $clientReference;
	}
	/**
	 * @return string
	 */
	public function getPreviousClientReference()
	{
		return $this -> m_szPreviousClientReference;
	}
	/**
	 * @param string $previousClientReference
	 */
	public function setPreviousClientReference($previousClientReference)
	{
		$this -> m_szPreviousClientReference = $previousClientReference;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szTransactionType = "";
		$this -> m_szCrossReference = "";
		$this -> m_boNewTransaction = new NullableBool();
		$this -> m_szClientReference = "";
		$this -> m_szPreviousClientReference = "";
	}

}
class TransactionDetails
{
	/**
	 * @var MessageDetails
	 */
	private $m_mdMessageDetails;
	/**
	 * @var NullableInt
	 */
	private $m_nAmount;
	/**
	 * @var NullableInt
	 */
	private $m_nCurrencyCode;
	/**
	 * @var string
	 */
	private $m_szCaptureEnvironment;
	/**
	 * @var NullableBool
	 */
	private $m_boContinuousAuthority;
	/**
	 * @var string
	 */
	private $m_szOrderID;
	/**
	 * @var string
	 */
	private $m_szOrderDescription;
	/**
	 * @var TransactionControl
	 */
	private $m_tcTransactionControl;
	/**
	 * @var ThreeDSecureBrowserDetails
	 */
	private $m_tdsbdThreeDSecureBrowserDetails;

	/**
	 * @return MessageDetails
	 */
	public function getMessageDetails()
	{
		return $this -> m_mdMessageDetails;
	}
	/**
	 * @return NullableInt
	 */
	public function getAmount()
	{
		return $this -> m_nAmount;
	}
	/**
	 * @return NullableInt
	 */
	public function getCurrencyCode()
	{
		return $this -> m_nCurrencyCode;
	}
	/**
	 * @return string
	 */
	public function getCaptureEnvironment()
	{
		return $this -> m_szCaptureEnvironment;
	}
	/**
	 * @param string $szCaptureEnvironment
	 */
	public function setCaptureEnvironment($szCaptureEnvironment)
	{
		$this -> m_szCaptureEnvironment = $szCaptureEnvironment;
	}
	/**
	 * @return NullableBool
	 */
	public function getContinuousAuthority()
	{
		return $this -> m_boContinuousAuthority;
	}
	/**
	 * @return string
	 */
	public function getOrderID()
	{
		return $this -> m_szOrderID;
	}
	/**
	 * @param string $orderID
	 */
	public function setOrderID($orderID)
	{
		$this -> m_szOrderID = $orderID;
	}
	/**
	 * @return string
	 */
	public function getOrderDescription()
	{
		return $this -> m_szOrderDescription;
	}
	/**
	 * @param string $orderDescription
	 */
	public function setOrderDescription($orderDescription)
	{
		$this -> m_szOrderDescription = $orderDescription;
	}
	/**
	 * @return TransactionControl
	 */
	public function getTransactionControl()
	{
		return $this -> m_tcTransactionControl;
	}
	/**
	 * @return ThreeDSecureBrowserDetails
	 */
	public function getThreeDSecureBrowserDetails()
	{
		return $this -> m_tdsbdThreeDSecureBrowserDetails;
	}

	//constructor
	public function __construct()
	{
		$this -> m_mdMessageDetails = new MessageDetails();
		$this -> m_nAmount = new NullableInt();
		$this -> m_szCaptureEnvironment = "";
		$this -> m_boContinuousAuthority = new NullableBool();
		$this -> m_nCurrencyCode = new NullableInt();
		$this -> m_szOrderID = "";
		$this -> m_szOrderDescription = "";
		$this -> m_tcTransactionControl = new TransactionControl();
		$this -> m_tdsbdThreeDSecureBrowserDetails = new ThreeDSecureBrowserDetails();
	}

}
class ThreeDSecureBrowserDetails
{
	/**
	 * @var NullableInt
	 */
	private $m_nDeviceCategory;
	/**
	 * @var string
	 */
	private $m_szAcceptHeaders;
	/**
	 * @var string
	 */
	private $m_szUserAgent;

	/**
	 * @return NullableInt
	 */
	public function getDeviceCategory()
	{
		return $this -> m_nDeviceCategory;
	}
	/**
	 * @return string
	 */
	public function getAcceptHeaders()
	{
		return $this -> m_szAcceptHeaders;
	}
	/**
	 * @param string $acceptHeaders
	 */
	public function setAcceptHeaders($acceptHeaders)
	{
		$this -> m_szAcceptHeaders = $acceptHeaders;
	}
	/**
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this -> m_szUserAgent;
	}
	/**
	 * @param string $userAgent
	 */
	public function setUserAgent($userAgent)
	{
		$this -> m_szUserAgent = $userAgent;
	}

	//constructor
	public function __construct()
	{
		$this -> m_nDeviceCategory = new NullableInt();
		$this -> m_szAcceptHeaders = "";
		$this -> m_szUserAgent = "";
	}

}
class TransactionControl
{
	/**
	 * @var NullableBool
	 */
	private $m_boEchoCardType;
	/**
	 * @var NullableBool
	 */
	private $m_boEchoAVSCheckResult;
	/**
	 * @var NullableBool
	 */
	private $m_boEchoCV2CheckResult;
	/**
	 * @var NullableBool
	 */
	private $m_boEchoAmountReceived;
	/**
	 * @var NullableInt
	 */
	private $m_nDuplicateDelay;
	/**
	 * @var string
	 */
	private $m_szAVSOverridePolicy;
	/**
	 * @var string
	 */
	private $m_szCV2OverridePolicy;
	/**
	 * @var NullableBool
	 */
	private $m_boThreeDSecureOverridePolicy;
	/**
	 * @var string
	 */
	private $m_szAuthCode;
	/**
	 * @var ThreeDSecurePassthroughData
	 */
	private $m_tdsptThreeDSecurePassthroughData;
	/**
	 * @var GenericVariableList
	 */
	private $m_lgvCustomVariables;

	/**
	 * @return NullableBool
	 */
	public function getEchoCardType()
	{
		return $this -> m_boEchoCardType;
	}
	/**
	 * @return NullableBool
	 */
	public function getEchoAVSCheckResult()
	{
		return $this -> m_boEchoAVSCheckResult;
	}
	/**
	 * @return NullableBool
	 */
	public function getEchoCV2CheckResult()
	{
		return $this -> m_boEchoCV2CheckResult;
	}
	/**
	 * @return NullableBool
	 */
	public function getEchoAmountReceived()
	{
		return $this -> m_boEchoAmountReceived;
	}
	/**
	 * @return NullableInt
	 */
	public function getDuplicateDelay()
	{
		return $this -> m_nDuplicateDelay;
	}
	/**
	 * @return string
	 */
	public function getAVSOverridePolicy()
	{
		return $this -> m_szAVSOverridePolicy;
	}
	/**
	 * @param string $AVSOverridePolicy
	 */
	public function setAVSOverridePolicy($AVSOverridePolicy)
	{
		$this -> m_szAVSOverridePolicy = $AVSOverridePolicy;
	}
	/**
	 * @return string
	 */
	public function getCV2OverridePolicy()
	{
		return $this -> m_szCV2OverridePolicy;
	}
	/**
	 * @param string $CV2OverridePolicy
	 */
	public function setCV2OverridePolicy($CV2OverridePolicy)
	{
		$this -> m_szCV2OverridePolicy = $CV2OverridePolicy;
	}
	/**
	 * @return NullableBool
	 */
	public function getThreeDSecureOverridePolicy()
	{
		return $this -> m_boThreeDSecureOverridePolicy;
	}
	/**
	 * @return string
	 */
	public function getAuthCode()
	{
		return $this -> m_szAuthCode;
	}
	/**
	 * @param string $authCode
	 */
	public function setAuthCode($authCode)
	{
		$this -> m_szAuthCode = $authCode;
	}
	/**
	 * @return ThreeDSecurePassthroughData
	 */
	function getThreeDSecurePassthroughData()
	{
		return $this -> m_tdsptThreeDSecurePassthroughData;
	}
	/**
	 * @return GenericVariableList
	 */
	public function getCustomVariables()
	{
		return $this -> m_lgvCustomVariables;
	}

	//constructor
	public function __construct()
	{
		$this -> m_boEchoCardType = new NullableBool();
		$this -> m_boEchoAVSCheckResult = new NullableBool();
		$this -> m_boEchoCV2CheckResult = new NullableBool();
		$this -> m_boEchoAmountReceived = new NullableBool();
		$this -> m_nDuplicateDelay = new NullableInt();
		$this -> m_szAVSOverridePolicy = "";
		$this -> m_szCV2OverridePolicy = "";
		$this -> m_boThreeDSecureOverridePolicy = new NullableBool();
		$this -> m_szAuthCode = "";
		$this -> m_tdsptThreeDSecurePassthroughData = new ThreeDSecurePassthroughData();
		$this -> m_lgvCustomVariables = new GenericVariableList();
	}

}
class ThreeDSecureInputData
{
	/**
	 * @var string
	 */
	private $m_szCrossReference;
	/**
	 * @var string
	 */
	private $m_szPaRES;
	/**
	 * @return string
	 */
	public function getCrossReference()
	{
		return $this -> m_szCrossReference;
	}

	/**
	 * @param string $crossReference
	 */
	public function setCrossReference($crossReference)
	{
		$this -> m_szCrossReference = $crossReference;
	}
	/**
	 * @return string
	 */
	public function getPaRES()
	{
		return $this -> m_szPaRES;
	}
	/**
	 * @param string $PaRES
	 */
	public function setPaRES($PaRES)
	{
		$this -> m_szPaRES = $PaRES;
	}

	//constructor
	public function __construct()
	{
		$this -> m_szCrossReference = "";
		$this -> m_szPaRES = "";
	}

}
class ThreeDSecurePassthroughData
{
	/**
	 * @var string
	 */
	private $m_szEnrolmentStatus;
	/**
	 * @var string
	 */
	private $m_szAuthenticationStatus;
	/**
	 * @var string
	 */
	private $m_szElectronicCommerceIndicator;
	/**
	 * @var string
	 */
	private $m_szAuthenticationValue;
	/**
	 * @var string
	 */
	private $m_szTransactionIdentifier;

	/**
	 * @return string
	 */
	function getEnrolmentStatus()
	{
		return $this -> m_szEnrolmentStatus;
	}
	/**
	 * @param string $enrolmentStatus
	 */
	public function setEnrolmentStatus($enrolmentStatus)
	{
		$this -> m_szEnrolmentStatus = $enrolmentStatus;
	}
	/**
	 * @return string
	 */
	function getAuthenticationStatus()
	{
		return $this -> m_szAuthenticationStatus;
	}
	/**
	 * @param string $authenticationStatus
	 */
	public function setAuthenticationStatus($authenticationStatus)
	{
		$this -> m_szAuthenticationStatus = $authenticationStatus;
	}
	/**
	 * @return string
	 */
	function getElectronicCommerceIndicator()
	{
		return $this -> m_szElectronicCommerceIndicator;
	}
	/**
	 * @param string $electronicCommerceIndicator
	 */
	public function setElectronicCommerceIndicator($electronicCommerceIndicator)
	{
		$this -> m_szElectronicCommerceIndicator = $electronicCommerceIndicator;
	}
	/**
	 * @return string
	 */
	function getAuthenticationValue()
	{
		return $this -> m_szAuthenticationValue;
	}
	/**
	 * @param string $authenticationValue
	 */
	public function setAuthenticationValue($authenticationValue)
	{
		$this -> m_szAuthenticationValue = $authenticationValue;
	}
	/**
	 * @return string
	 */
	function getTransactionIdentifier()
	{
		return $this -> m_szTransactionIdentifier;
	}
	/**
	 * @param string $transactionIdentifier
	 */
	public function setTransactionIdentifier($transactionIdentifier)
	{
		$this -> m_szTransactionIdentifier = $transactionIdentifier;
	}

	//constructor
	function __construct()
	{
		$this -> m_szEnrolmentStatus = "";
		$this -> m_szAuthenticationStatus = "";
		$this -> m_szElectronicCommerceIndicator = "";
		$this -> m_szAuthenticationValue = "";
		$this -> m_szTransactionIdentifier = "";
	}

}
/******************/
/* Output classes */
/******************/
class Issuer
{
	/**
	 * @var string
	 */
	private $m_szIssuer;
	/**
	 * @var NullableInt
	 */
	private $m_nISOCode;

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this -> m_szIssuer;
	}

	/**
	 * @return NullableInt
	 */
	public function getISOCode()
	{
		return $this -> m_nISOCode;
	}

	//constructor
	public function __construct($szIssuer, NullableInt $nISOCode = null)
	{
		$this -> m_szIssuer = $szIssuer;
		$this -> m_nISOCode = $nISOCode;
	}

}
class CardTypeData
{
	/**
	 * @var string
	 */
	private $m_szCardType;
	/**
	 * @var Issuer
	 */
	private $m_iIssuer;
	/**
	 * @var string
	 */
	private $m_szCardClass;
	/**
	 * @var NullableBool
	 */
	private $m_boLuhnCheckRequired;
	/**
	 * @var string
	 */
	private $m_szIssueNumberStatus;
	/**
	 * @var string
	 */
	private $m_szStartDateStatus;

	/**
	 * @return string
	 */
	public function getCardType()
	{
		return $this -> m_szCardType;
	}
	/**
	 * @return string
	 */
	public function getCardClass()
	{
		return $this -> m_szCardClass;
	}
	/**
	 * @return Issuer
	 */
	public function getIssuer()
	{
		return $this -> m_iIssuer;
	}
	/**
	 * @return NullableBool
	 */
	public function getLuhnCheckRequired()
	{
		return $this -> m_boLuhnCheckRequired;
	}
	/**
	 * @return string
	 */
	public function getIssueNumberStatus()
	{
		return $this -> m_szIssueNumberStatus;
	}
	/**
	 * @return string
	 */
	public function getStartDateStatus()
	{
		return $this -> m_szStartDateStatus;
	}

	//constructor
	/**
	 * @param string       $szCardType
	 * @param string       $szCardClass
	 * @param string       $iIssuer
	 * @param NullableBool $boLuhnCheckRequired
	 * @param string       $szIssueNumberStatus
	 * @param string       $szStartDateStatus
	 */
	public function __construct($szCardType, $szCardClass, $iIssuer, NullableBool $boLuhnCheckRequired = null, $szIssueNumberStatus, $szStartDateStatus)
	{
		$this -> m_szCardType = $szCardType;
		$this -> m_szCardClass = $szCardClass;
		$this -> m_iIssuer = $iIssuer;
		$this -> m_boLuhnCheckRequired = $boLuhnCheckRequired;
		$this -> m_szIssueNumberStatus = $szIssueNumberStatus;
		$this -> m_szStartDateStatus = $szStartDateStatus;
	}

}
class GatewayEntryPoint
{
	/**
	 * @var string
	 */
	private $m_szEntryPointURL;
	/**
	 * @var int
	 */
	private $m_nMetric;

	/**
	 * @return string
	 */
	public function getEntryPointURL()
	{
		return $this -> m_szEntryPointURL;
	}
	/**
	 * @return int
	 */
	public function getMetric()
	{
		return $this -> m_nMetric;
	}
	/**
	 * @return string
	 */
	public function toXmlString()
	{
		$szXmlString = "<GatewayEntryPoint EntryPointURL=\"" . $this -> m_szEntryPointURL . "\" Metric=\"" . $this -> m_nMetric . "\" />";

		return ($szXmlString);
	}

	//constructor
	/**
	 * @param string $szEntryPointURL
	 * @param int    $nMetric
	 */
	public function __construct($szEntryPointURL, $nMetric)
	{
		$this -> m_szEntryPointURL = $szEntryPointURL;
		$this -> m_nMetric = $nMetric;
	}

}
class GatewayEntryPointList
{
	/**
	 * @var GatewayEntryPoint[]
	 */
	private $m_lgepGatewayEntryPoint;

	/**
	 * @param  int               $nIndex
	 * @return GatewayEntryPoint
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lgepGatewayEntryPoint))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_lgepGatewayEntryPoint[$nIndex];
	}
	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lgepGatewayEntryPoint);
	}
	/**
	 * @param string $GatewayEntrypointURL
	 * @param int    $nMetric
	 */
	public function add($GatewayEntrypointURL, $nMetric)
	{
		array_push($this -> m_lgepGatewayEntryPoint, new GatewayEntryPoint($GatewayEntrypointURL, $nMetric));
	}
	/**
	 * @param  string                $szXmlString
	 * @return GatewayEntryPointList
	 * @throws Exception
	 */
	public static function fromXmlString($szXmlString)
	{
		$xpXmlParser = new XmlParser();

		if (!$xpXmlParser -> parseBuffer($szXmlString))
		{
			throw new Exception("Could not parse response string");
		}
		else
		{
			// look to see if there are any gateway entry points
			$nCount = 0;
			$szXmlFormatString1 = "GatewayEntryPoint[";
			$szXmlFormatString2 = "]";
			$lgepGatewayEntryPoints = null;

			while ($xpXmlParser -> getStringValue($szXmlFormatString1 . $nCount . $szXmlFormatString2 . ".EntryPointURL", $szEntryPointURL))
			{
				if (!$xpXmlParser -> getIntegerValue($szXmlFormatString1 . $nCount . $szXmlFormatString2 . ".Metric", $nMetric))
				{
					$nMetric = -1;
				}
				if ($lgepGatewayEntryPoints == null)
				{
					$lgepGatewayEntryPoints = new GatewayEntryPointList();
				}
				$lgepGatewayEntryPoints -> add($szEntryPointURL, $nMetric);
				$nCount++;
			}
		}
		return ($lgepGatewayEntryPoints);
	}
	/**
	 * @return string
	 * @throws Exception
	 */
	public function toXmlString()
	{
		$szXmlString = "<GatewayEntryPoints>";

		for ($nCount = 0; $nCount < $this -> getCount(); $nCount++)
		{
			$szXmlString = $szXmlString . $this -> getAt($nCount) -> toXmlString();
		}
		$szXmlString = $szXmlString . "</GatewayEntryPoints>";

		return ($szXmlString);
	}

	//constructor
	public function __construct()
	{
		$this -> m_lgepGatewayEntryPoint = array();
	}

}
class PreviousTransactionResult
{
	/**
	 * @var NullableInt
	 */
	private $m_nStatusCode;
	/**
	 * @var string
	 */
	private $m_szMessage;

	/**
	 * @return NullableInt
	 */
	function getStatusCode()
	{
		return $this -> m_nStatusCode;
	}
	/**
	 * @return string
	 */
	function getMessage()
	{
		return $this -> m_szMessage;
	}

	/**
	 * @param NullableInt $nStatusCode
	 * @param string      $szMessage
	 */
	function __construct(NullableInt $nStatusCode = null, $szMessage)
	{
		$this -> m_nStatusCode = $nStatusCode;
		$this -> m_szMessage = $szMessage;
	}

}
class GatewayOutput
{
	/**
	 * @var int
	 */
	private $m_nStatusCode;
	/**
	 * @var string
	 */
	private $m_szMessage;
	/**
	 * @var StringList
	 */
	private $m_lszErrorMessages;

	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this -> m_nStatusCode;
	}
	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this -> m_szMessage;
	}
	/**
	 * @return StringList
	 */
	public function getErrorMessages()
	{
		return $this -> m_lszErrorMessages;
	}

	//constructor
	/**
	 * @param int        $nStatusCode
	 * @param string     $szMessage
	 * @param StringList $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, StringList $lszErrorMessages = null)
	{
		$this -> m_nStatusCode = $nStatusCode;
		$this -> m_szMessage = $szMessage;
		$this -> m_lszErrorMessages = $lszErrorMessages;
	}

}
class PaymentMessageGatewayOutput extends GatewayOutput
{
	/**
	 * @var PreviousTransactionResult
	 */
	private $m_ptdPreviousTransactionResult;
	/**
	 * @var NullableBool
	 */
	private $m_boAuthorisationAttempted;

	/**
	 * @return PreviousTransactionResult
	 */
	public function getPreviousTransactionResult()
	{
		return $this -> m_ptdPreviousTransactionResult;
	}
	/**
	 * @return NullableBool
	 */
	public function getAuthorisationAttempted()
	{
		return $this -> m_boAuthorisationAttempted;
	}

	//constructor
	/**
	 * @param int                       $nStatusCode
	 * @param string                    $szMessage
	 * @param NullableBool              $boAuthorisationAttempted
	 * @param PreviousTransactionResult $ptdPreviousTransactionResult
	 * @param StringList                $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, NullableBool $boAuthorisationAttempted = null, PreviousTransactionResult $ptdPreviousTransactionResult = null, StringList $lszErrorMessages = null)
	{
		parent::__construct($nStatusCode, $szMessage, $lszErrorMessages);
		$this -> m_boAuthorisationAttempted = $boAuthorisationAttempted;
		$this -> m_ptdPreviousTransactionResult = $ptdPreviousTransactionResult;
	}

}
class CardDetailsTransactionResult extends PaymentMessageGatewayOutput
{
	/**
	 * @param int                       $nStatusCode
	 * @param string                    $szMessage
	 * @param NullableBool              $boAuthorisationAttempted
	 * @param PreviousTransactionResult $ptdPreviousTransactionResult
	 * @param StringList                $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, NullableBool $boAuthorisationAttempted = null, PreviousTransactionResult $ptdPreviousTransactionResult = null, StringList $lszErrorMessages = null)
	{
		parent::__construct($nStatusCode, $szMessage, $boAuthorisationAttempted, $ptdPreviousTransactionResult, $lszErrorMessages);
	}

}
class CrossReferenceTransactionResult extends PaymentMessageGatewayOutput
{
	/**
	 * @param int                       $nStatusCode
	 * @param string                    $szMessage
	 * @param NullableBool              $boAuthorisationAttempted
	 * @param PreviousTransactionResult $ptdPreviousTransactionResult
	 * @param StringList                $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, NullableBool $boAuthorisationAttempted = null, PreviousTransactionResult $ptdPreviousTransactionResult = null, StringList $lszErrorMessages = null)
	{
		parent::__construct($nStatusCode, $szMessage, $boAuthorisationAttempted, $ptdPreviousTransactionResult, $lszErrorMessages);
	}

}
class ThreeDSecureTransactionResult extends PaymentMessageGatewayOutput
{
	/**
	 * @param int                       $nStatusCode
	 * @param string                    $szMessage
	 * @param NullableBool              $boAuthorisationAttempted
	 * @param PreviousTransactionResult $ptdPreviousTransactionResult
	 * @param StringList                $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, NullableBool $boAuthorisationAttempted = null, PreviousTransactionResult $ptdPreviousTransactionResult = null, StringList $lszErrorMessages = null)
	{
		parent::__construct($nStatusCode, $szMessage, $boAuthorisationAttempted, $ptdPreviousTransactionResult, $lszErrorMessages);
	}

}
class GetGatewayEntryPointsResult extends GatewayOutput
{
	/**
	 * @param int        $nStatusCode
	 * @param string     $szMessage
	 * @param StringList $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, StringList $lszErrorMessages = null)
	{
		parent::__construct($nStatusCode, $szMessage, $lszErrorMessages);
	}

}
class GetCardTypeResult extends GatewayOutput
{
	/**
	 * @param int        $nStatusCode
	 * @param string     $szMessage
	 * @param StringList $lszErrorMessages
	 */
	public function __construct($nStatusCode, $szMessage, StringList $lszErrorMessages = null)
	{
		parent::__construct($nStatusCode, $szMessage, $lszErrorMessages);
	}

}
class ThreeDSecureOutputData
{
	/**
	 * @var string
	 */
	private $m_szPaREQ;
	/**
	 * @var string
	 */
	private $m_szACSURL;

	/**
	 * @return string
	 */
	public function getPaREQ()
	{
		return $this -> m_szPaREQ;
	}
	/**
	 * @return string
	 */
	public function getACSURL()
	{
		return ($this -> m_szACSURL);
	}

	//constructor
	/**
	 * @param string $szPaREQ
	 * @param string $szACSURL
	 */
	public function __construct($szPaREQ, $szACSURL)
	{
		$this -> m_szPaREQ = $szPaREQ;
		$this -> m_szACSURL = $szACSURL;
	}

}
class GetGatewayEntryPointsOutputData extends BaseOutputData
{
	//constructor
	function __construct(GatewayEntryPointList $lgepGatewayEntryPoints = null)
	{
		parent::__construct($lgepGatewayEntryPoints);
	}

}
class TransactionOutputData extends BaseOutputData
{
	/**
	 * @var string
	 */
	private $m_szCrossReference;
	/**
	 * @var string
	 */
	private $m_szAuthCode;
	/**
	 * @var string
	 */
	private $m_szAddressNumericCheckResult;
	/**
	 * @var string
	 */
	private $m_szPostCodeCheckResult;
	/**
	 * @var string
	 */
	private $m_szThreeDSecureAuthenticationCheckResult;
	/**
	 * @var string
	 */
	private $m_szCV2CheckResult;
	/**
	 * @var CardTypeData
	 */
	private $m_ctdCardTypeData;
	/**
	 * @var NullableInt
	 */
	private $m_nAmountReceived;
	/**
	 * @var ThreeDSecureOutputData
	 */
	private $m_tdsodThreeDSecureOutputData;
	/**
	 * @var GenericVariableList
	 */
	private $m_lgvCustomVariables;
	/**
	 * @var GatewayEntryPointList
	 */
	private $m_gepodGatewayEntryPointsOutputData;

	/**
	 * @return string
	 */
	public function getCrossReference()
	{
		return $this -> m_szCrossReference;
	}
	/**
	 * @return string
	 */
	public function getAuthCode()
	{
		return $this -> m_szAuthCode;
	}
	/**
	 * @return string
	 */
	public function getAddressNumericCheckResult()
	{
		return $this -> m_szAddressNumericCheckResult;
	}
	/**
	 * @return string
	 */
	public function getPostCodeCheckResult()
	{
		return $this -> m_szPostCodeCheckResult;
	}
	/**
	 * @return string
	 */
	public function getThreeDSecureAuthenticationCheckResult()
	{
		return $this -> m_szThreeDSecureAuthenticationCheckResult;
	}
	/**
	 * @return string
	 */
	public function getCV2CheckResult()
	{
		return $this -> m_szCV2CheckResult;
	}
	/**
	 * @return CardTypeData
	 */
	public function getCardTypeData()
	{
		return $this -> m_ctdCardTypeData;
	}
	/**
	 * @return NullableInt
	 */
	public function getAmountReceived()
	{
		return $this -> m_nAmountReceived;
	}
	/**
	 * @return ThreeDSecureOutputData
	 */
	public function getThreeDSecureOutputData()
	{
		return $this -> m_tdsodThreeDSecureOutputData;
	}
	/**
	 * @return GenericVariableList
	 */
	public function getCustomVariables()
	{
		return $this -> m_lgvCustomVariables;
	}
	/**
	 * @return GatewayEntryPointList
	 */
	public function getGatewayEntryPoints()
	{
		return $this -> m_gepodGatewayEntryPointsOutputData;
	}

	//constructor
	/**
	 * @param GatewayEntryPointList  $szCrossReference
	 * @param string                 $szAuthCode
	 * @param string                 $szAddressNumericCheckResult
	 * @param string                 $szPostCodeCheckResult
	 * @param string                 $szThreeDSecureAuthenticationCheckResult
	 * @param string                 $szCV2CheckResult
	 * @param CardTypeData           $ctdCardTypeData
	 * @param NullableInt            $nAmountReceived
	 * @param ThreeDSecureOutputData $tdsodThreeDSecureOutputData
	 * @param GenericVariableList    $lgvCustomVariables
	 * @param GatewayEntryPointList  $lgepGatewayEntryPoints
	 */
	public function __construct($szCrossReference, $szAuthCode, $szAddressNumericCheckResult, $szPostCodeCheckResult, $szThreeDSecureAuthenticationCheckResult, $szCV2CheckResult, CardTypeData $ctdCardTypeData = null, NullableInt $nAmountReceived = null, ThreeDSecureOutputData $tdsodThreeDSecureOutputData = null, GenericVariableList $lgvCustomVariables = null, GatewayEntryPointList $lgepGatewayEntryPoints = null)
	{
		//first calling the parent constructor
		parent::__construct($lgepGatewayEntryPoints);

		$this -> m_szCrossReference = $szCrossReference;
		$this -> m_szAuthCode = $szAuthCode;
		$this -> m_szAddressNumericCheckResult = $szAddressNumericCheckResult;
		$this -> m_szPostCodeCheckResult = $szPostCodeCheckResult;
		$this -> m_szThreeDSecureAuthenticationCheckResult = $szThreeDSecureAuthenticationCheckResult;
		$this -> m_szCV2CheckResult = $szCV2CheckResult;
		$this -> m_ctdCardTypeData = $ctdCardTypeData;
		$this -> m_nAmountReceived = $nAmountReceived;
		$this -> m_tdsodThreeDSecureOutputData = $tdsodThreeDSecureOutputData;
		$this -> m_lgvCustomVariables = $lgvCustomVariables;
		$this -> m_gepodGatewayEntryPointsOutputData = $lgepGatewayEntryPoints;
	}

}
class GetCardTypeOutputData extends BaseOutputData
{
	/**
	 * @var CardTypeData
	 */
	private $m_ctdCardTypeData;

	/**
	 * @return CardTypeData
	 */
	public function getCardTypeData()
	{
		return $this -> m_ctdCardTypeData;
	}
	//constructor
	/**
	 * @param CardTypeData          $ctdCardTypeData
	 * @param GatewayEntryPointList $lgepGatewayEntryPoints
	 */
	public function __construct(CardTypeData $ctdCardTypeData = null, GatewayEntryPointList $lgepGatewayEntryPoints = null)
	{
		parent::__construct($lgepGatewayEntryPoints);

		$this -> m_ctdCardTypeData = $ctdCardTypeData;
	}

}
class BaseOutputData
{
	/**
	 * @var GatewayEntryPointList
	 */
	private $m_lgepGatewayEntryPoints;

	/**
	 * @return GatewayEntryPointList
	 */
	public function getGatewayEntryPoints()
	{
		return $this -> m_lgepGatewayEntryPoints;
	}

	//constructor
	/**
	 * @param GatewayEntryPointList $lgepGatewayEntryPoints
	 */
	public function __construct(GatewayEntryPointList $lgepGatewayEntryPoints = null)
	{
		$this -> m_lgepGatewayEntryPoints = $lgepGatewayEntryPoints;
	}

}
/********************/
/* Gateway messages */
/********************/
class GetGatewayEntryPoints extends GatewayTransaction
{
	/**
	 * @param GetGatewayEntryPointsResult     $ggeprGetGatewayEntryPointsResult    Passed as reference
	 * @param GetGatewayEntryPointsOutputData $ggepGetGatewayEntryPointsOutputData Passed as reference
	 * @return bool
	 * @throws Exception
	 */
	function processTransaction(GetGatewayEntryPointsResult &$ggeprGetGatewayEntryPointsResult = null, GetGatewayEntryPointsOutputData &$ggepGetGatewayEntryPointsOutputData = null)
	{
		
		$boTransactionSubmitted = false;
		$sSOAPClient;
		$lgepGatewayEntryPoints;

		$ggepGetGatewayEntryPointsOutputData = null;
		$goGatewayOutput = null;

		$sSOAPClient = new SOAP("GetGatewayEntryPoints", GatewayTransaction::getSOAPNamespace());

		$boTransactionSubmitted = GatewayTransaction::processTransactionBase($sSOAPClient, "GetGatewayEntryPointsMessage", "GetGatewayEntryPointsResult", "GetGatewayEntryPointsOutputData", $goGatewayOutput, $lgepGatewayEntryPoints);

		if ($boTransactionSubmitted)
		{
			$ggeprGetGatewayEntryPointsResult = $goGatewayOutput;

			$ggepGetGatewayEntryPointsOutputData = new GetGatewayEntryPointsOutputData($lgepGatewayEntryPoints);
		}

		return $boTransactionSubmitted;
	}

	//constructor
	/**
	 * @param RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints
	 * @param int                          $nRetryAttempts
	 * @param NullableInt                  $nTimeout
	 */
	public function __construct(RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints = null, $nRetryAttempts = 1, NullableInt $nTimeout = null)
	{
		if ($nRetryAttempts == null && $nTimeout == null)
		{
			GatewayTransaction::__construct($lrgepRequestGatewayEntryPoints, 1, null);
		}
		else
		{
			GatewayTransaction::__construct($lrgepRequestGatewayEntryPoints, $nRetryAttempts, $nTimeout);
		}
	}

}
class CardDetailsTransaction extends GatewayTransaction
{
	/**
	 * @var TransactionDetails
	 */
	private $m_tdTransactionDetails;
	/**
	 * @var CardDetails
	 */
	private $m_cdCardDetails;
	/**
	 * @var CustomerDetails
	 */
	private $m_cdCustomerDetails;

	/**
	 * @return TransactionDetails
	 */
	public function getTransactionDetails()
	{
		return $this -> m_tdTransactionDetails;
	}
	/**
	 * @return CardDetails
	 */
	public function getCardDetails()
	{
		return $this -> m_cdCardDetails;
	}
	/**
	 * @return CustomerDetails
	 */
	public function getCustomerDetails()
	{
		return $this -> m_cdCustomerDetails;
	}
	/**
	 * @param  CardDetailsTransactionResult $cdtrCardDetailsTransactionResult Passed by reference
	 * @param  TransactionOutputData        $todTransactionOutputData         Passed by reference
	 * @return bool
	 * @throws Exception
	 */
	public function processTransaction(CardDetailsTransactionResult &$cdtrCardDetailsTransactionResult = null, TransactionOutputData &$todTransactionOutputData = null)
	{
		$boTransactionSubmitted = false;
		$sSOAPClient;
		$lgepGatewayEntryPoints = null;
		$goGatewayOutput = null;

		$todTransactionOutputData = null;
		$cdtrCardDetailsTransactionResult = null;

		$sSOAPClient = new SOAP("CardDetailsTransaction", parent::getSOAPNamespace());

		// transaction details
		if ($this -> m_tdTransactionDetails != null)
		{
			if ($this -> m_tdTransactionDetails -> getAmount() != null)
			{
				if ($this -> m_tdTransactionDetails -> getAmount() -> getHasValue())
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "Amount", (string)$this -> m_tdTransactionDetails -> getAmount() -> getValue());
				}
			}
			if ($this -> m_tdTransactionDetails -> getCurrencyCode() != null)
			{
				if ($this -> m_tdTransactionDetails -> getCurrencyCode() -> getHasValue())
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "CurrencyCode", (string)$this -> m_tdTransactionDetails -> getCurrencyCode() -> getValue());
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getCaptureEnvironment()))
			{
				$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "CaptureEnvironment", $this -> m_tdTransactionDetails -> getCaptureEnvironment());
			}
			if ($this -> m_tdTransactionDetails -> getContinuousAuthority() != null)
			{
				if ($this -> m_tdTransactionDetails -> getContinuousAuthority() -> getHasValue())
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "ContinuousAuthority", (string)$this -> m_tdTransactionDetails -> getContinuousAuthority() -> getValue());
				}
			}
			if ($this -> m_tdTransactionDetails -> getMessageDetails() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getMessageDetails() -> getClientReference()))
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "ClientReference", $this -> m_tdTransactionDetails -> getMessageDetails() -> getClientReference());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getMessageDetails() -> getTransactionType()))
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "TransactionType", $this -> m_tdTransactionDetails -> getMessageDetails() -> getTransactionType());
				}
			}
			if ($this -> m_tdTransactionDetails -> getTransactionControl() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getAuthCode()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.AuthCode", $this -> m_tdTransactionDetails -> getTransactionControl() -> getAuthCode());
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecureOverridePolicy() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecureOverridePolicy() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecureOverridePolicy", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecureOverridePolicy() -> getValue()));
					}
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getAVSOverridePolicy()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.AVSOverridePolicy", $this -> m_tdTransactionDetails -> getTransactionControl() -> getAVSOverridePolicy());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getCV2OverridePolicy()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.CV2OverridePolicy", ($this -> m_tdTransactionDetails -> getTransactionControl() -> getCV2OverridePolicy()));
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getDuplicateDelay() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getDuplicateDelay() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.DuplicateDelay", (string)$this -> m_tdTransactionDetails -> getTransactionControl() -> getDuplicateDelay() -> getValue());
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCardType() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCardType() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoCardType", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCardType() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoAVSCheckResult", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoAVSCheckResult", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCV2CheckResult() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCV2CheckResult() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoCV2CheckResult", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCV2CheckResult() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAmountReceived() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAmountReceived() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoAmountReceived", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAmountReceived() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() != null)
				{
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getEnrolmentStatus()))
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecurePassthroughData", "EnrolmentStatus", $this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getEnrolmentStatus());
					}
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getAuthenticationStatus()))
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecurePassthroughData", "AuthenticationStatus", $this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getAuthenticationStatus());
					}
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getElectronicCommerceIndicator()))
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecurePassthroughData.ElectronicCommerceIndicator", $this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getElectronicCommerceIndicator());
					}
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getAuthenticationValue()))
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecurePassthroughData.AuthenticationValue", $this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getAuthenticationValue());
					}
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getTransactionIdentifier()))
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecurePassthroughData.TransactionIdentifier", $this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecurePassthroughData() -> getTransactionIdentifier());
					}
				}
			}
			if ($this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getAcceptHeaders()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.ThreeDSecureBrowserDetails.AcceptHeaders", $this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getAcceptHeaders());
				}
				if ($this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getDeviceCategory() != null)
				{
					if ($this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getDeviceCategory() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.ThreeDSecureBrowserDetails", "DeviceCategory", (string)$this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getDeviceCategory() -> getValue());
					}
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getUserAgent()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.ThreeDSecureBrowserDetails.UserAgent", $this -> m_tdTransactionDetails -> getThreeDSecureBrowserDetails() -> getUserAgent());
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getOrderID()))
			{
				$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.OrderID", $this -> m_tdTransactionDetails -> getOrderID());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getOrderDescription()))
			{
				$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.OrderDescription", $this -> m_tdTransactionDetails -> getOrderDescription());
			}
		}
		// card details
		if ($this -> m_cdCardDetails != null)
		{
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCardDetails -> getCardName()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CardDetails.CardName", $this -> m_cdCardDetails -> getCardName());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCardDetails -> getCV2()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CardDetails.CV2", $this -> m_cdCardDetails -> getCV2());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCardDetails -> getCardNumber()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CardDetails.CardNumber", $this -> m_cdCardDetails -> getCardNumber());
			}
			if ($this -> m_cdCardDetails -> getExpiryDate() != null)
			{
				if ($this -> m_cdCardDetails -> getExpiryDate() -> getMonth() != null)
				{
					if ($this -> m_cdCardDetails -> getExpiryDate() -> getMonth() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.CardDetails.ExpiryDate", "Month", (string)$this -> m_cdCardDetails -> getExpiryDate() -> getMonth() -> getValue());
					}
				}
				if ($this -> m_cdCardDetails -> getExpiryDate() -> getYear() != null)
				{
					if ($this -> m_cdCardDetails -> getExpiryDate() -> getYear() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.CardDetails.ExpiryDate", "Year", (string)$this -> m_cdCardDetails -> getExpiryDate() -> getYear() -> getValue());
					}
				}
			}
			if ($this -> m_cdCardDetails -> getStartDate() != null)
			{
				if ($this -> m_cdCardDetails -> getStartDate() -> getMonth() != null)
				{
					if ($this -> m_cdCardDetails -> getStartDate() -> getMonth() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.CardDetails.StartDate", "Month", (string)$this -> m_cdCardDetails -> getStartDate() -> getMonth() -> getValue());
					}
				}
				if ($this -> m_cdCardDetails -> getStartDate() -> getYear() != null)
				{
					if ($this -> m_cdCardDetails -> getStartDate() -> getYear() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.CardDetails.StartDate", "Year", (string)$this -> m_cdCardDetails -> getStartDate() -> getYear() -> getValue());
					}
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCardDetails -> getIssueNumber()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CardDetails.IssueNumber", $this -> m_cdCardDetails -> getIssueNumber());
			}
		}
		// customer details
		if ($this -> m_cdCustomerDetails != null)
		{
			if ($this -> m_cdCustomerDetails -> getBillingAddress() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress1()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address1", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress1());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress2()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address2", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress2());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress3()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address3", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress3());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress4()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address4", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress4());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getCity()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.City", $this -> m_cdCustomerDetails -> getBillingAddress() -> getCity());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getState()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.State", $this -> m_cdCustomerDetails -> getBillingAddress() -> getState());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getPostCode()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.PostCode", $this -> m_cdCustomerDetails -> getBillingAddress() -> getPostCode());
				}
				if ($this -> m_cdCustomerDetails -> getBillingAddress() -> getCountryCode() != null)
				{
					if ($this -> m_cdCustomerDetails -> getBillingAddress() -> getCountryCode() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.CountryCode", (string)$this -> m_cdCustomerDetails -> getBillingAddress() -> getCountryCode() -> getValue());
					}
				}
			}
			if ($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() != null)
			{
				if ( $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAddressDetails() != null)
				{
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAddressDetails() ->getPostCode()))
					{
						$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.AddressDetails.PostCode", (string)$this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAddressDetails() ->getPostCode());
					}
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getName()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.Name", $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getName());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAccountNumber()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.AccountNumber", $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAccountNumber());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getDateOfBirth()))
				{
					$sSOAPClient.AddParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.DateOfBirth", $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getDateOfBirth());
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getEmailAddress()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.EmailAddress", $this -> m_cdCustomerDetails -> getEmailAddress());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPhoneNumber()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PhoneNumber", $this -> m_cdCustomerDetails -> getPhoneNumber());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getCustomerIPAddress()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.CustomerIPAddress", $this -> m_cdCustomerDetails -> getCustomerIPAddress());
			}
		}

		$boTransactionSubmitted = GatewayTransaction::processTransactionBase($sSOAPClient, "PaymentMessage", "CardDetailsTransactionResult", "TransactionOutputData", $goGatewayOutput, $lgepGatewayEntryPoints);

		if ($boTransactionSubmitted)
		{
			$cdtrCardDetailsTransactionResult = SharedFunctionsPaymentSystemShared::getPaymentMessageGatewayOutput($sSOAPClient -> getXmlTag(), "CardDetailsTransactionResult", $goGatewayOutput);

			$todTransactionOutputData = SharedFunctionsPaymentSystemShared::getTransactionOutputData($sSOAPClient -> getXmlTag(), $lgepGatewayEntryPoints);
		}

		return ($boTransactionSubmitted);
	}

	/**
	 * @param RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints
	 * @param int                          $nRetryAttempts
	 * @param NullableInt                  $nTimeout
	 */
	public function __construct(RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints = null, $nRetryAttempts = 1, NullableInt $nTimeout = null)
	{
		parent::__construct($lrgepRequestGatewayEntryPoints, $nRetryAttempts, $nTimeout);

		$this -> m_tdTransactionDetails = new TransactionDetails();
		$this -> m_cdCardDetails = new CardDetails();
		$this -> m_cdCustomerDetails = new CustomerDetails();
	}

}
class CrossReferenceTransaction extends GatewayTransaction
{
	/**
	 * @var TransactionDetails
	 */
	private $m_tdTransactionDetails;
	/**
	 * @var OverrideCardDetails
	 */
	private $m_ocdOverrideCardDetails;
	/**
	 * @var CustomerDetails
	 */
	private $m_cdCustomerDetails;

	/**
	 * @return TransactionDetails
	 */
	public function getTransactionDetails()
	{
		return $this -> m_tdTransactionDetails;
	}
	/**
	 * @return OverrideCardDetails
	 */
	public function getOverrideCardDetails()
	{
		return $this -> m_ocdOverrideCardDetails;
	}
	/**
	 * @return CustomerDetails
	 */
	public function getCustomerDetails()
	{
		return $this -> m_cdCustomerDetails;
	}
	/**
	 * @param  CrossReferenceTransactionResult $crtrCrossReferenceTransactionResult Passed by reference
	 * @param  TransactionOutputData           $todTransactionOutputData            Passed by reference
	 * @return bool
	 * @throws Exception
	 */
	public function processTransaction(CrossReferenceTransactionResult &$crtrCrossReferenceTransactionResult = null, TransactionOutputData &$todTransactionOutputData = null)
	{
		$boTransactionSubmitted = false;
		$sSOAPClient;
		$lgepGatewayEntryPoints = null;

		$todTransactionOutputData = null;
		$goGatewayOutput = null;

		$sSOAPClient = new SOAP("CrossReferenceTransaction", GatewayTransaction::getSOAPNamespace());
		// transaction details
		if ($this -> m_tdTransactionDetails != null)
		{
			if ($this -> m_tdTransactionDetails -> getAmount() != null)
			{
				if ($this -> m_tdTransactionDetails -> getAmount() -> getHasValue())
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "Amount", (string)$this -> m_tdTransactionDetails -> getAmount() -> getValue());
				}
			}
			if ($this -> m_tdTransactionDetails -> getCurrencyCode() != null)
			{
				if ($this -> m_tdTransactionDetails -> getCurrencyCode() -> getHasValue())
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "CurrencyCode", (string)$this -> m_tdTransactionDetails -> getCurrencyCode() -> getValue());
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getCaptureEnvironment()))
			{
				$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "CaptureEnvironment", $this -> m_tdTransactionDetails -> getCaptureEnvironment());
			}
			if ($this -> m_tdTransactionDetails -> getContinuousAuthority() != null)
			{
				if ($this -> m_tdTransactionDetails -> getContinuousAuthority() -> getHasValue())
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails", "ContinuousAuthority", (string)$this -> m_tdTransactionDetails -> getContinuousAuthority() -> getValue());
				}
			}
			if ($this -> m_tdTransactionDetails -> getMessageDetails() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getMessageDetails() -> getClientReference()))
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "ClientReference", $this -> m_tdTransactionDetails -> getMessageDetails() -> getClientReference());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getMessageDetails() -> getPreviousClientReference()))
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "PreviousClientReference", $this -> m_tdTransactionDetails -> getMessageDetails() -> getPreviousClientReference());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getMessageDetails() -> getTransactionType()))
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "TransactionType", $this -> m_tdTransactionDetails -> getMessageDetails() -> getTransactionType());
				}
				if ($this -> m_tdTransactionDetails -> getMessageDetails() -> getNewTransaction() != null)
				{
					if ($this -> m_tdTransactionDetails -> getMessageDetails() -> getNewTransaction() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "NewTransaction", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getMessageDetails() -> getNewTransaction() -> getValue()));
					}
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getMessageDetails() -> getCrossReference()))
				{
					$sSOAPClient -> addParamAttribute("PaymentMessage.TransactionDetails.MessageDetails", "CrossReference", $this -> m_tdTransactionDetails -> getMessageDetails() -> getCrossReference());
				}
			}
			if ($this -> m_tdTransactionDetails -> getTransactionControl() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getAuthCode()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.AuthCode", $this -> m_tdTransactionDetails -> getTransactionControl() -> getAuthCode());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecureOverridePolicy()))
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecureOverridePolicy() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.ThreeDSecureOverridePolicy", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getThreeDSecureOverridePolicy() -> getValue()));
					}
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getAVSOverridePolicy()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.AVSOverridePolicy", $this -> m_tdTransactionDetails -> getTransactionControl() -> getAVSOverridePolicy());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getTransactionControl() -> getCV2OverridePolicy()))
				{
					$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.CV2OverridePolicy", $this -> m_tdTransactionDetails -> getTransactionControl() -> getCV2OverridePolicy());
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getDuplicateDelay() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getDuplicateDelay() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.DuplicateDelay", (string)($this -> m_tdTransactionDetails -> getTransactionControl() -> getDuplicateDelay() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCardType() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCardType() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoCardType", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCardType() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoAVSCheckResult", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoAVSCheckResult", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAVSCheckResult() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCV2CheckResult() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCV2CheckResult() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoCV2CheckResult", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoCV2CheckResult() -> getValue()));
					}
				}
				if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAmountReceived() != null)
				{
					if ($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAmountReceived() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.TransactionControl.EchoAmountReceived", SharedFunctions::boolToString($this -> m_tdTransactionDetails -> getTransactionControl() -> getEchoAmountReceived() -> getValue()));
					}
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getOrderID()))
			{
				$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.OrderID", $this -> m_tdTransactionDetails -> getOrderID());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdTransactionDetails -> getOrderDescription()))
			{
				$sSOAPClient -> addParam("PaymentMessage.TransactionDetails.OrderDescription", $this -> m_tdTransactionDetails -> getOrderDescription());
			}
		}
		// card details
		if ($this -> m_ocdOverrideCardDetails != null)
		{
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_ocdOverrideCardDetails -> getCardName()))
			{
				$sSOAPClient -> addParam("PaymentMessage.OverrideCardDetails.CardName", $this -> m_ocdOverrideCardDetails -> getCardName());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_ocdOverrideCardDetails -> getCV2()))
			{
				$sSOAPClient -> addParam("PaymentMessage.OverrideCardDetails.CV2", $this -> m_ocdOverrideCardDetails -> getCV2());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_ocdOverrideCardDetails -> getCardNumber()))
			{
				$sSOAPClient -> addParam("PaymentMessage.OverrideCardDetails.CardNumber", $this -> m_ocdOverrideCardDetails -> getCardNumber());
			}
			if ($this -> m_ocdOverrideCardDetails -> getExpiryDate() != null)
			{
				if ($this -> m_ocdOverrideCardDetails -> getExpiryDate() -> getMonth() != null)
				{
					if ($this -> m_ocdOverrideCardDetails -> getExpiryDate() -> getMonth() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.OverrideCardDetails.ExpiryDate", "Month", (string)$this -> m_ocdOverrideCardDetails -> getExpiryDate() -> getMonth() -> getValue());
					}
				}
				if ($this -> m_ocdOverrideCardDetails -> getExpiryDate() -> getYear() != null)
				{
					if ($this -> m_ocdOverrideCardDetails -> getExpiryDate() -> getYear() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.OverrideCardDetails.ExpiryDate", "Year", (string)$this -> m_ocdOverrideCardDetails -> getExpiryDate() -> getYear() -> getValue());
					}
				}
			}
			if ($this -> m_ocdOverrideCardDetails -> getStartDate() != null)
			{
				if ($this -> m_ocdOverrideCardDetails -> getStartDate() -> getMonth() != null)
				{
					if ($this -> m_ocdOverrideCardDetails -> getStartDate() -> getMonth() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.OverrideCardDetails.StartDate", "Month", (string)$this -> m_ocdOverrideCardDetails -> getStartDate() -> getMonth() -> getValue());
					}
				}
				if ($this -> m_ocdOverrideCardDetails -> getStartDate() -> getYear() != null)
				{
					if ($this -> m_ocdOverrideCardDetails -> getStartDate() -> getYear() -> getHasValue())
					{
						$sSOAPClient -> addParamAttribute("PaymentMessage.OverrideCardDetails.StartDate", "Year", (string)$this -> m_ocdOverrideCardDetails -> getStartDate() -> getYear() -> getValue());
					}
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_ocdOverrideCardDetails -> getIssueNumber()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CardDetails.IssueNumber", $this -> m_ocdOverrideCardDetails -> getIssueNumber());
			}
		}
		// customer details
		if ($this -> m_cdCustomerDetails != null)
		{
			if ($this -> m_cdCustomerDetails -> getBillingAddress() != null)
			{
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress1()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address1", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress1());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress2()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address2", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress2());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress3()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address3", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress3());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress4()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.Address4", $this -> m_cdCustomerDetails -> getBillingAddress() -> getAddress4());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getCity()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.City", $this -> m_cdCustomerDetails -> getBillingAddress() -> getCity());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getState()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.State", $this -> m_cdCustomerDetails -> getBillingAddress() -> getState());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getBillingAddress() -> getPostCode()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.PostCode", (string)$this -> m_cdCustomerDetails -> getBillingAddress() -> getPostCode());
				}
				if ($this -> m_cdCustomerDetails -> getBillingAddress() -> getCountryCode() != null)
				{
					if ($this -> m_cdCustomerDetails -> getBillingAddress() -> getCountryCode() -> getHasValue())
					{
						$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.BillingAddress.CountryCode", (string)$this -> m_cdCustomerDetails -> getBillingAddress() -> getCountryCode() -> getValue());
					}
				}
			}
			if ($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() != null)
			{
				if ( $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAddressDetails() != null)
				{
					if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAddressDetails() ->getPostCode()))
					{
						$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.AddressDetails.PostCode", (string)$this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAddressDetails() ->getPostCode());
					}
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getName()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.Name", $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getName());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAccountNumber()))
				{
					$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.AccountNumber", $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getAccountNumber());
				}
				if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getDateOfBirth()))
				{
					$sSOAPClient.AddParam("PaymentMessage.CustomerDetails.PrimaryAccountDetails.DateOfBirth", $this -> m_cdCustomerDetails -> getPrimaryAccountDetails() -> getDateOfBirth());
				}
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getEmailAddress()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.EmailAddress", $this -> m_cdCustomerDetails -> getEmailAddress());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getPhoneNumber()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.PhoneNumber", $this -> m_cdCustomerDetails -> getPhoneNumber());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_cdCustomerDetails -> getCustomerIPAddress()))
			{
				$sSOAPClient -> addParam("PaymentMessage.CustomerDetails.CustomerIPAddress", $this -> m_cdCustomerDetails -> getCustomerIPAddress());
			}
		}

		$boTransactionSubmitted = GatewayTransaction::processTransactionBase($sSOAPClient, "PaymentMessage", "CrossReferenceTransactionResult", "TransactionOutputData", $goGatewayOutput, $lgepGatewayEntryPoints);

		if ($boTransactionSubmitted)
		{
			$crtrCrossReferenceTransactionResult = SharedFunctionsPaymentSystemShared::getPaymentMessageGatewayOutput($sSOAPClient -> getXmlTag(), "CrossReferenceTransactionResult", $goGatewayOutput);

			$todTransactionOutputData = SharedFunctionsPaymentSystemShared::getTransactionOutputData($sSOAPClient -> getXmlTag(), $lgepGatewayEntryPoints);
		}

		return $boTransactionSubmitted;
	}

	//constructor
	/**
	 * @param RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints
	 * @param int                          $nRetryAttempts
	 * @param NullableInt                  $nTimeout
	 */
	public function __construct(RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints = null, $nRetryAttempts = 1, NullableInt $nTimeout = null)
	{
		GatewayTransaction::__construct($lrgepRequestGatewayEntryPoints, $nRetryAttempts, $nTimeout);

		$this -> m_tdTransactionDetails = new TransactionDetails();
		$this -> m_ocdOverrideCardDetails = new OverrideCardDetails();
		$this -> m_cdCustomerDetails = new CustomerDetails();
	}

}
class ThreeDSecureAuthentication extends GatewayTransaction
{
	/**
	 * @var ThreeDSecureInputData
	 */
	private $m_tdsidThreeDSecureInputData;

	/**
	 * @return ThreeDSecureInputData
	 */
	public function getThreeDSecureInputData()
	{
		return $this -> m_tdsidThreeDSecureInputData;
	}
	/**
	 * @param  ThreeDSecureAuthenticationResult $tdsarThreeDSecureAuthenticationResult Passed by reference
	 * @param  TransactionOutputData            $todTransactionOutputData              Passed by reference
	 * @return bool
	 * @throws Exception
	 */
	public function processTransaction(ThreeDSecureAuthenticationResult &$tdsarThreeDSecureAuthenticationResult = null, TransactionOutputData &$todTransactionOutputData = null)
	{
		$boTransactionSubmitted = false;
		$sSOAPClient;
		$lgepGatewayEntryPoints = null;

		$todTransactionOutputData = null;
		$goGatewayOutput = null;

		$sSOAPClient = new SOAP("ThreeDSecureAuthentication", GatewayTransaction::getSOAPNamespace());
		if ($this -> m_tdsidThreeDSecureInputData != null)
		{
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdsidThreeDSecureInputData -> getCrossReference()))
			{
				$sSOAPClient -> addParamAttribute("ThreeDSecureMessage.ThreeDSecureInputData", "CrossReference", $this -> m_tdsidThreeDSecureInputData -> getCrossReference());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_tdsidThreeDSecureInputData -> getPaRES()))
			{
				$sSOAPClient -> addParam("ThreeDSecureMessage.ThreeDSecureInputData.PaRES", $this -> m_tdsidThreeDSecureInputData -> getPaRES());
			}
		}

		$boTransactionSubmitted = GatewayTransaction::processTransactionBase($sSOAPClient, "ThreeDSecureMessage", "ThreeDSecureAuthenticationResult", "TransactionOutputData", $goGatewayOutput, $lgepGatewayEntryPoints);

		if ($boTransactionSubmitted)
		{
			$tdsarThreeDSecureAuthenticationResult = SharedFunctionsPaymentSystemShared::getPaymentMessageGatewayOutput($sSOAPClient -> getXmlTag(), "ThreeDSecureAuthenticationResult", $goGatewayOutput);

			$todTransactionOutputData = SharedFunctionsPaymentSystemShared::getTransactionOutputData($sSOAPClient -> getXmlTag(), $lgepGatewayEntryPoints);
		}

		return $boTransactionSubmitted;
	}

	//constructor
	/**
	 * @param RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints
	 * @param int                          $nRetryAttempts
	 * @param NullableInt                  $nTimeout
	 */
	public function __construct(RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints = null, $nRetryAttempts = 1, NullableInt $nTimeout = null)
	{
		GatewayTransaction::__construct($lrgepRequestGatewayEntryPoints, $nRetryAttempts, $nTimeout);

		$this -> m_tdsidThreeDSecureInputData = new ThreeDSecureInputData();
	}

}
class GetCardType extends GatewayTransaction
{
	/**
	 * @var string
	 */
	private $m_szCardNumber;

	/**
	 * @return string
	 */
	public function getCardNumber()
	{
		return $this -> m_szCardNumber;
	}
	/**
	 * @param string $cardNumber
	 */
	public function setCardNumber($cardNumber)
	{
		$this -> m_szCardNumber = $cardNumber;
	}
	/**
	 * @param  GetCardTypeResult     $gctrGetCardTypeResult      Passed by reference
	 * @param  GetCardTypeOutputData $gctodGetCardTypeOutputData Passed by reference
	 * @return bool
	 * @throws Exception
	 */
	public function processTransaction(GetCardTypeResult &$gctrGetCardTypeResult = null, GetCardTypeOutputData &$gctodGetCardTypeOutputData = null)
	{
		$boTransactionSubmitted = false;
		$sSOAPClient;
		$lgepGatewayEntryPoints = null;
		$ctdCardTypeData = null;

		$gctodGetCardTypeOutputData = null;
		$goGatewayOutput = null;

		$sSOAPClient = new SOAP("GetCardType", GatewayTransaction::getSOAPNamespace());
		if (!SharedFunctions::isStringNullOrEmpty($this -> m_szCardNumber))
		{
			$sSOAPClient -> addParam("GetCardTypeMessage.CardNumber", $this -> m_szCardNumber);
		}

		$boTransactionSubmitted = GatewayTransaction::processTransactionBase($sSOAPClient, "GetCardTypeMessage", "GetCardTypeResult", "GetCardTypeOutputData", $goGatewayOutput, $lgepGatewayEntryPoints);

		if ($boTransactionSubmitted)
		{
			$gctrGetCardTypeResult = $goGatewayOutput;

			$ctdCardTypeData = SharedFunctionsPaymentSystemShared::getCardTypeData($sSOAPClient -> getXmlTag(), "GetCardTypeOutputData.CardTypeData");

			$gctodGetCardTypeOutputData = new GetCardTypeOutputData($ctdCardTypeData, $lgepGatewayEntryPoints);
		}
		return $boTransactionSubmitted;
	}

	//constructor
	/**
	 * @param RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints
	 * @param int                          $nRetryAttempts
	 * @param NullableInt                  $nTimeout
	 */
	public function __construct(RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints = null, $nRetryAttempts = 1, NullableInt $nTimeout = null)
	{
		GatewayTransaction::__construct($lrgepRequestGatewayEntryPoints, $nRetryAttempts, $nTimeout);

		$this -> m_szCardNumber = "";
	}

}
abstract class GatewayTransaction
{
	/**
	 * @var MerchantAuthentication
	 */
	private $m_maMerchantAuthentication;
	/**
	 * @var RequestGatewayEntryPointList
	 */
	private $m_lrgepRequestGatewayEntryPoints;
	/**
	 * @var int
	 */
	private $m_nRetryAttempts;
	/**
	 * @var NullableInt
	 */
	private $m_nTimeout;
	/**
	 * @var string
	 */
	private $m_szSOAPNamespace = "https://www.thepaymentgateway.net/";
	/**
	 * @var string
	 */
	private $m_szLastRequest;
	/**
	 * @var string
	 */
	private $m_szLastResponse;
	/**
	 * @var Exception
	 */
	private $m_eLastException;
	/**
	 * @var string
	 */
	private $m_szEntryPointUsed;

	/**
	 * @return MerchantAuthentication
	 */
	public function getMerchantAuthentication()
	{
		return $this -> m_maMerchantAuthentication;
	}
	/**
	 * @return RequestGatewayEntryPointList
	 */
	public function getRequestGatewayEntryPoints()
	{
		return $this -> m_lrgepRequestGatewayEntryPoints;
	}
	/**
	 * @return int
	 */
	public function getRetryAttempts()
	{
		return $this -> m_nRetryAttempts;
	}
	/**
	 * @return NullableInt
	 */
	public function getTimeout()
	{
		return $this -> m_nTimeout;
	}
	/**
	 * @return string
	 */
	public function getSOAPNamespace()
	{
		return $this -> m_szSOAPNamespace;
	}
	/**
	 * @param string $value
	 */
	public function setSOAPNamespace($value)
	{
		$this -> m_szSOAPNamespace = $value;
	}
	/**
	 * @return string
	 */
	public function getLastRequest()
	{
		return $this -> m_szLastRequest;
	}
	/**
	 * @return string
	 */
	public function getLastResponse()
	{
		return $this -> m_szLastResponse;
	}
	/**
	 * @return Exception
	 */
	public function getLastException()
	{
		return $this -> m_eLastException;
	}
	/**
	 * @return string
	 */
	public function getEntryPointUsed()
	{
		return $this -> m_szEntryPointUsed;
	}
	/**
	 * @param RequestGatewayEntryPoint $x
	 * @param RequestGatewayEntryPoint $y
	 * @return int
	 */
	public static function compare($x, $y)
	{
		$rgepFirst = null;
		$rgepSecond = null;

		$rgepFirst = $x;
		$rgepSecond = $y;

		return (GatewayTransaction::compareGatewayEntryPoints($rgepFirst, $rgepSecond));
	}
	/**
	 * @param  RequestGatewayEntryPoint $rgepFirst
	 * @param  RequestGatewayEntryPoint $rgepSecond
	 * @return int
	 */
	private static function compareGatewayEntryPoints(RequestGatewayEntryPoint $rgepFirst, RequestGatewayEntryPoint $rgepSecond)
	{
		$nReturnValue = 0;
		// returns >0 if rgepFirst greater than rgepSecond
		// returns 0 if they are equal
		// returns <0 if rgepFirst less than rgepSecond

		// both null, then they are the same
		if ($rgepFirst == null && $rgepSecond == null)
		{
			$nReturnValue = 0;
		}
		// just first null? then second is greater
		elseif ($rgepFirst == null && $rgepSecond != null)
		{
			$nReturnValue = 1;
		}
		// just second null? then first is greater
		elseif ($rgepFirst != null && $rgepSecond == null)
		{
			$nReturnValue = -1;
		}
		// can now assume that first & second both have a value
		elseif ($rgepFirst -> getMetric() == $rgepSecond -> getMetric())
		{
			$nReturnValue = 0;
		}
		elseif ($rgepFirst -> getMetric() < $rgepSecond -> getMetric())
		{
			$nReturnValue = -1;
		}
		elseif ($rgepFirst -> getMetric() > $rgepSecond -> getMetric())
		{
			$nReturnValue = 1;
		}

		return $nReturnValue;
	}
	/**
	 * @param SOAP                  $sSOAPClient
	 * @param string                $szMessageXMLPath
	 * @param string                $szGatewayOutputXMLPath
	 * @param string                $szTransactionMessageXMLPath
	 * @param GatewayOutput         $goGatewayOutput
	 * @param GatewayEntryPointList $lgepGatewayEntryPoints
	 * @return bool
	 * @throws Exception
	 */
	protected function processTransactionBase(SOAP $sSOAPClient, $szMessageXMLPath, $szGatewayOutputXMLPath, $szTransactionMessageXMLPath, GatewayOutput &$goGatewayOutput = null, GatewayEntryPointList &$lgepGatewayEntryPoints = null)
	{
		$boTransactionSubmitted = false;
		$nOverallRetryCount = 0;
		$nOverallGatewayEntryPointCount = 0;
		$nGatewayEntryPointCount = 0;
		$nErrorMessageCount = 0;
		$rgepCurrentGatewayEntryPoint;
		$nStatusCode;
		$szMessage = null;
		$lszErrorMessages;
		$szString;
		$sbXMLString;
		$szXMLFormatString;
		$nCount = 0;
		$szEntryPointURL;
		$nMetric;
		$gepGatewayEntryPoint = null;

		$lgepGatewayEntryPoints = null;
		$goGatewayOutput = null;

		$this -> m_szEntryPointUsed = null;

		if ($sSOAPClient == null)
		{
			return false;
		}

		// populate the merchant details
		if ($this -> m_maMerchantAuthentication != null)
		{
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_maMerchantAuthentication -> getMerchantID()))
			{
				$sSOAPClient -> addParamAttribute($szMessageXMLPath . ".MerchantAuthentication", "MerchantID", $this -> m_maMerchantAuthentication -> getMerchantID());
			}
			if (!SharedFunctions::isStringNullOrEmpty($this -> m_maMerchantAuthentication -> getPassword()))
			{
				$sSOAPClient -> addParamAttribute($szMessageXMLPath . ".MerchantAuthentication", "Password", $this -> m_maMerchantAuthentication -> getPassword());
			}
		}

		// first need to sort the gateway entry points into the correct usage order
		$number = $this -> m_lrgepRequestGatewayEntryPoints -> sort("GatewayTransaction", "Compare");

		// loop over the overall number of transaction attempts
		while (!$boTransactionSubmitted && $nOverallRetryCount < $this -> m_nRetryAttempts)
		{
			$nOverallGatewayEntryPointCount = 0;

			// loop over the number of gateway entry points in the list
			while (!$boTransactionSubmitted && $nOverallGatewayEntryPointCount < $this -> m_lrgepRequestGatewayEntryPoints -> getCount())
			{
				$rgepCurrentGatewayEntryPoint = $this -> m_lrgepRequestGatewayEntryPoints -> getAt($nOverallGatewayEntryPointCount);

				// ignore if the metric is "-1" this indicates that the entry point is offline
				if ($rgepCurrentGatewayEntryPoint -> getMetric() >= 0)
				{
					$nGatewayEntryPointCount = 0;
					$sSOAPClient -> setURL($rgepCurrentGatewayEntryPoint -> getEntryPointURL());

					// loop over the number of times to try this specific entry point
					while (!$boTransactionSubmitted && $nGatewayEntryPointCount < $rgepCurrentGatewayEntryPoint -> getRetryAttempts())
					{
						if ($sSOAPClient -> sendRequest())
						{
							if ($sSOAPClient -> getXmlTag() -> getIntegerValue($szGatewayOutputXMLPath . ".StatusCode", $nStatusCode))
							{
								// a status code of 50 means that this entry point is not to be used
								if ($nStatusCode != 50)
								{
									$this -> m_szEntryPointUsed = $rgepCurrentGatewayEntryPoint -> getEntryPointURL();

									// the transaction was submitted
									$boTransactionSubmitted = true;

									$sSOAPClient -> getXmlTag() -> getStringValue($szGatewayOutputXMLPath . ".Message", $szMessage);

									$nErrorMessageCount = 0;
									$lszErrorMessages = new StringList();
									$szXmlFormatString1 = $szGatewayOutputXMLPath . ".ErrorMessages.MessageDetail[";
									$szXmlFormatString2 = "].Detail";

									while ($sSOAPClient -> getXmlTag() -> getStringValue($szXmlFormatString1 . $nErrorMessageCount . $szXmlFormatString2, $szString))
									{
										$lszErrorMessages -> add($szString);

										$nErrorMessageCount++;
									}

									$goGatewayOutput = new GatewayOutput($nStatusCode, $szMessage, $lszErrorMessages);

									// look to see if there are any gateway entry points
									$nCount = 0;
									$szXmlFormatString1 = $szTransactionMessageXMLPath . ".GatewayEntryPoints.GatewayEntryPoint[";
									$szXmlFormatString2 = "]";

									while ($sSOAPClient -> getXmlTag() -> getStringValue($szXmlFormatString1 . $nCount . $szXmlFormatString2 . ".EntryPointURL", $szEntryPointURL))
									{
										if (!$sSOAPClient -> getXmlTag() -> getIntegerValue($szXmlFormatString1 . $nCount . $szXmlFormatString2 . ".Metric", $nMetric))
										{
											$nMetric = -1;
										}
										if ($lgepGatewayEntryPoints == null)
										{
											$lgepGatewayEntryPoints = new GatewayEntryPointList();
										}
										$lgepGatewayEntryPoints -> add($szEntryPointURL, $nMetric);
										$nCount++;
									}
								}
							}
						}

						$nGatewayEntryPointCount++;
					}
				}
				$nOverallGatewayEntryPointCount++;
			}
			$nOverallRetryCount++;
		}
		$this -> m_szLastRequest = $sSOAPClient -> getSOAPPacket();
		$this -> m_szLastResponse = $sSOAPClient -> getLastResponse();
		$this -> m_eLastException = $sSOAPClient -> getLastException();

		return $boTransactionSubmitted;
	}

	public function __construct(RequestGatewayEntryPointList $lrgepRequestGatewayEntryPoints = null, $nRetryAttempts = 1, NullableInt $nTimeout = null)
	{
		$this -> m_maMerchantAuthentication = new MerchantAuthentication();
		$this -> m_lrgepRequestGatewayEntryPoints = $lrgepRequestGatewayEntryPoints;
		$this -> m_nRetryAttempts = $nRetryAttempts;
		$this -> m_nTimeout = $nTimeout;
	}

}
class SharedFunctionsPaymentSystemShared
{
	/**
	 * @param  XmlTag                $xtTransactionOutputDataXmlTag
	 * @param  GatewayEntryPointList $lgepGatewayEntryPoints
	 * @return TransactionOutputData
	 * @throws Exception
	 */
	public static function getTransactionOutputData(XmlTag $xtTransactionOutputDataXmlTag, GatewayEntryPointList $lgepGatewayEntryPoints = null)
	{
		$szCrossReference = "";
		$szAddressNumericCheckResult = "";
		$szPostCodeCheckResult = "";
		$szThreeDSecureAuthenticationCheckResult = "";
		$szCV2CheckResult = "";
		$nAmountReceived = null;
		$szPaREQ = "";
		$szACSURL = "";
		$ctdCardTypeData = null;
		$tdsodThreeDSecureOutputData = null;
		$lgvCustomVariables = null;
		$nCount = 0;
		$szAuthCode = "";
		$todTransactionOutputData = null;

		if ($xtTransactionOutputDataXmlTag == null)
		{
			return (null);
		}

		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.CrossReference", $szCrossReference);
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.AuthCode", $szAuthCode);
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.AddressNumericCheckResult", $szAddressNumericCheckResult);
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.PostCodeCheckResult", $szPostCodeCheckResult);
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.ThreeDSecureAuthenticationCheckResult", $szThreeDSecureAuthenticationCheckResult);
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.CV2CheckResult", $szCV2CheckResult);

		$ctdCardTypeData = SharedFunctionsPaymentSystemShared::getCardTypeData($xtTransactionOutputDataXmlTag, "TransactionOutputData.CardTypeData");
		if ($xtTransactionOutputDataXmlTag -> getIntegerValue("TransactionOutputData.AmountReceived", $nTempValue))
		{
			$nAmountReceived = new NullableInt($nTempValue);
		}
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.ThreeDSecureOutputData.PaREQ", $szPaREQ);
		$xtTransactionOutputDataXmlTag -> getStringValue("TransactionOutputData.ThreeDSecureOutputData.ACSURL", $szACSURL);

		if (!SharedFunctions::isStringNullOrEmpty($szACSURL) && !SharedFunctions::isStringNullOrEmpty($szPaREQ))
		{
			$tdsodThreeDSecureOutputData = new ThreeDSecureOutputData($szPaREQ, $szACSURL);
		}

		$nCount = 0;
		$szXmlFormatString1 = "TransactionOutputData.CustomVariables.GenericVariable[";
		$szXmlFormatString2 = "]";

		while ($xtTransactionOutputDataXmlTag -> getStringValue($szXmlFormatString1 . $nCount . $szXmlFormatString2 . ".Name", $szName))
		{
			if (!$xtTransactionOutputDataXmlTag -> getValue($szXmlFormatString1 . $nCount . $szXmlFormatString2 . ".Value", $szValue))
			{
				$szValue = "";
			}
			if ($lgvCustomVariables == null)
			{
				$lgvCustomVariables = new GenericVariableList();
			}
			$lgvCustomVariables -> add($szName, $szValue);
			$nCount++;
		}

		$todTransactionOutputData = new TransactionOutputData($szCrossReference, $szAuthCode, $szAddressNumericCheckResult, $szPostCodeCheckResult, $szThreeDSecureAuthenticationCheckResult, $szCV2CheckResult, $ctdCardTypeData, $nAmountReceived, $tdsodThreeDSecureOutputData, $lgvCustomVariables, $lgepGatewayEntryPoints);

		return ($todTransactionOutputData);
	}
	/**
	 * @param XmlTag        $xtGetCardTypeXmlTag
	 * @param string        $szCardTypeDataXMLPath
	 * @return CardTypeData
	 * @throws Exception
	 */
	public static function getCardTypeData(XmlTag $xtGetCardTypeXmlTag, $szCardTypeDataXMLPath)
	{
		$ctdCardTypeData = null;
		$boTempValue;
		$nISOCode = null;
		$boLuhnCheckRequired = null;
		$szStartDateStatus = null;
		$szIssueNumberStatus = null;
		$szCardType;
		$szIssuer = null;
		$nTemp;
		$iIssuer;
		$szCardClass;

		if ($xtGetCardTypeXmlTag == null)
		{
			return (null);
		}

		if ($xtGetCardTypeXmlTag -> getStringValue($szCardTypeDataXMLPath . ".CardType", $szCardType))
		{
			$xtGetCardTypeXmlTag -> getStringValue($szCardTypeDataXMLPath . ".CardClass", $szCardClass);
			$xtGetCardTypeXmlTag -> getStringValue($szCardTypeDataXMLPath . ".Issuer", $szIssuer);
			if ($xtGetCardTypeXmlTag -> getIntegerValue($szCardTypeDataXMLPath . ".Issuer.ISOCode", $nTemp))
			{
				$nISOCode = new NullableInt($nTemp);
			}
			$iIssuer = new Issuer($szIssuer, $nISOCode);
			if ($xtGetCardTypeXmlTag -> getBooleanValue($szCardTypeDataXMLPath . ".LuhnCheckRequired", $boTempValue))
			{
				$boLuhnCheckRequired = new NullableBool($boTempValue);
			}
			$xtGetCardTypeXmlTag -> getStringValue($szCardTypeDataXMLPath . ".IssueNumberStatus", $szIssueNumberStatus);
			$xtGetCardTypeXmlTag -> getStringValue($szCardTypeDataXMLPath . ".StartDateStatus", $szStartDateStatus);
			$ctdCardTypeData = new CardTypeData($szCardType, $szCardClass, $iIssuer, $boLuhnCheckRequired, $szIssueNumberStatus, $szStartDateStatus);
		}

		return ($ctdCardTypeData);
	}
	/**
	 * @param  XmlTag                      $xtMessageResultXmlTag
	 * @param  string                      $szGatewayOutputXMLPath
	 * @param  GatewayOutput               $goGatewayOutput
	 * @return PaymentMessageGatewayOutput
	 * @throws Exception
	 */
	public static function getPaymentMessageGatewayOutput(XmlTag $xtMessageResultXmlTag, $szGatewayOutputXMLPath, GatewayOutput $goGatewayOutput = null)
	{
		$nTempValue = 0;
		$boAuthorisationAttempted = null;
		$boTempValue;
		$nPreviousStatusCode = null;
		$szPreviousMessage = null;
		$ptrPreviousTransactionResult = null;
		$pmgoPaymentMessageGatewayOutput;

		if ($xtMessageResultXmlTag == null)
		{
			return (null);
		}

		if ($xtMessageResultXmlTag -> getBooleanValue($szGatewayOutputXMLPath . ".AuthorisationAttempted", $boTempValue))
		{
			$boAuthorisationAttempted = new NullableBool($boTempValue);
		}

		// check to see if there is any previous transaction data
		if ($xtMessageResultXmlTag -> getIntegerValue($szGatewayOutputXMLPath . ".PreviousTransactionResult.StatusCode", $nTempValue))
		{
			$nPreviousStatusCode = new NullableInt($nTempValue);
		}
		$xtMessageResultXmlTag -> getStringValue($szGatewayOutputXMLPath . ".PreviousTransactionResult.Message", $szPreviousMessage);
		if ($nPreviousStatusCode != null && !SharedFunctions::isStringNullOrEmpty($szPreviousMessage))
		{
			$ptrPreviousTransactionResult = new PreviousTransactionResult($nPreviousStatusCode, $szPreviousMessage);
		}

		$pmgoPaymentMessageGatewayOutput = new PaymentMessageGatewayOutput($goGatewayOutput -> getStatusCode(), $goGatewayOutput -> getMessage(), $boAuthorisationAttempted, $ptrPreviousTransactionResult, $goGatewayOutput -> getErrorMessages());

		return ($pmgoPaymentMessageGatewayOutput);
	}

}