<?php

/**
 * XMLEntities
 * @var XMLEntity[] $g_XMLEntities
 */
$g_XMLEntities = array();
$g_XMLEntities[] = new XMLEntity(0x26, "&amp;");
$g_XMLEntities[] = new XMLEntity(0x22, "&quot;");
$g_XMLEntities[] = new XMLEntity(0x27, "&apos;");
$g_XMLEntities[] = new XMLEntity(0x3c, "&lt;");
$g_XMLEntities[] = new XMLEntity(0x3e, "&gt;");

abstract class Nullable
{
	/**
	 * @var bool
	 */
	protected $m_boHasValue;

	/**
	 * @return bool
	 */
	function getHasValue()
	{
		return $this -> m_boHasValue;
	}

	public function __construct()
	{
		$this -> m_boHasValue = false;
	}

}
class NullableInt extends Nullable
{
	/**
	 * @var int
	 */
	private $m_nValue;

	/**
	 * @return int
	 * @throws Exception
	 */
	function getValue()
	{
		if ($this -> m_boHasValue == false)
		{
			throw new Exception("Object has no value");
		}

		return $this -> m_nValue;
	}
	/**
	 * @param int $nValue
	 */
	function setValue($nValue)
	{
		if (!is_numeric($nValue))
		{
			$this -> m_boHasValue = false;
			$this -> m_nValue = null;
		}
		else
		{
			$this -> m_boHasValue = true;
			$this -> m_nValue = $nValue;
		}
	}

	//constructor
	/**
	 * @param int|null $nValue
	 */
	public function __construct($nValue = null)
	{
		Nullable::__construct();

		if (is_numeric($nValue))
		{
			$this -> setValue($nValue);
		}
	}

}
class NullableBool extends Nullable
{
	/**
	 * @var bool
	 */
	private $m_boValue;

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function getValue()
	{
		if ($this -> m_boHasValue == false)
		{
			throw new Exception("Object has no value");
		}

		return ($this -> m_boValue);
	}
	/**
	 * @param bool $boValue
	 */
	public function setValue($boValue)
	{
		if (!is_bool($boValue))
		{
			$this -> m_boHasValue = false;
			$this -> m_boValue = null;
		}
		else
		{
			$this -> m_boHasValue = true;
			$this -> m_boValue = $boValue;
		}
	}

	//constructor
	/**
	 * @param bool|null $boValue
	 */
	public function __construct($boValue = null)
	{
		Nullable::__construct();

		if (is_bool($boValue))
		{
			$this -> setValue($boValue);
		}
	}

}
/******************/
/* Common classes */
/******************/
class StringList
{
	/**
	 * @var array
	 */
	private $m_lszStrings;

	/**
	 * @param  int       $nIndex
	 * @return string
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lszStrings))
		{
			throw new Exception("Array index out of bounds");
		}

		return (string)($this -> m_lszStrings[$nIndex]);
	}
	/**
	 * @return int
	 */
	function getCount()
	{
		return count($this -> m_lszStrings);
	}
	/**
	 * @param  string    $szString
	 * @return string
	 * @throws Exception
	 */
	function add($szString)
	{
		if (!is_string($szString))
		{
			throw new Exception("Invalid parameter type");
		}

		return ($this -> m_lszStrings[] = $szString);
	}

	//constructor
	function __construct()
	{
		$this -> m_lszStrings = array();
	}

}
class ISOCountry
{
	/**
	 * @var string
	 */
	private $m_szCountryName;
	/**
	 * @var string
	 */
	private $m_szCountryShort2;
	/**
	 * @var string
	 */
	private $m_szCountryShort3;
	/**
	 * @var int
	 */
	private $m_nISOCode;
	/**
	 * @var int
	 */
	private $m_nListPriority;

	/**
	 * @return string
	 */
	public function getCountryName()
	{
		return $this -> m_szCountryName;
	}
	/**
	 * @return string
	 */
	public function getCountryShort2()
	{
		return $this -> m_szCountryShort2;
	}
	/**
	 * @return string
	 */
	public function getCountryShort3()
	{
		return $this -> m_szCountryShort3;
	}
	/**
	 * @return int
	 */
	public function getISOCode()
	{
		return $this -> m_nISOCode;
	}
	/**
	 * @return int
	 */
	public function getListPriority()
	{
		return $this -> m_nListPriority;
	}

	//constructor
	/**
	 * @param  int       $nISOCode
	 * @param  string    $szCountryShort2
	 * @param  string    $szCountryShort3
	 * @param  string    $szCountryName
	 * @param  int       $nListPriority
	 * @throws Exception
	 */
	public function __construct($nISOCode, $szCountryShort2, $szCountryShort3, $szCountryName, $nListPriority)
	{
		if (!is_int($nISOCode) || !is_string($szCountryName) || !is_string($szCountryShort2) || !is_string($szCountryShort3) || !is_int($nListPriority))
		{
			throw new Exception("Invalid parameter type");
		}

		$this -> m_nISOCode = $nISOCode;
		$this -> m_szCountryShort2 = $szCountryShort2;
		$this -> m_szCountryShort3 = $szCountryShort3;
		$this -> m_szCountryName = $szCountryName;
		$this -> m_nListPriority = $nListPriority;
	}

}
class ISOCountryList
{
	/**
	 * @var ISOCountry[]
	 */
	private $m_licISOCountries;

	/**
	 * @param  string     $szCountry
	 * @param  ISOCountry $icISOCountry Passed by reference
	 * @return bool
	 */
	public function getISOCountry($szCountry, &$icISOCountry)
	{
		$boFound = false;
		$nCount = 0;
		$icISOCountry2;

		$icISOCountry = null;

		while ($nCount < count($this -> m_licISOCountries))
		{
			$icISOCountry2 = $this -> m_licISOCountries[$nCount];

			if (($szCountry == $icISOCountry2 -> getCountryShort2()) || ($szCountry == $icISOCountry2 -> getCountryShort3()) || ($szCountry == $icISOCountry2 -> getISOCode()))
			{
				$icISOCountry = new ISOCountry($icISOCountry2 -> getISOCode(), $icISOCountry2 -> getCountryShort2(), $icISOCountry2 -> getCountryShort3(), $icISOCountry2 -> getCountryName(), $icISOCountry2 -> getListPriority());
				$boFound = true;
				break;
			}

			$nCount++;
		}

		return $boFound;
	}
	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_licISOCountries);
	}
	/**
	 * @param  int        $nIndex
	 * @return ISOCountry
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_licISOCountries))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_licISOCountries[$nIndex];
	}
	/**
	 * @param int    $nISOCode
	 * @param string $szCountryShort2
	 * @param string $szCountryShort3
	 * @param string $szCountryName
	 * @param int    $nListPriority
	 */
	public function add($nISOCode, $szCountryShort2, $szCountryShort3, $szCountryName, $nListPriority)
	{
		$newISOCountry = new ISOCountry($nISOCode, $szCountryShort2, $szCountryShort3, $szCountryName, $nListPriority);

		$this -> m_licISOCountries[] = $newISOCountry;
	}

	//constructor
	public function __construct()
	{
		$this -> m_licISOCountries = array();
	}

}
class ISOCurrency
{
	/**
	 * @var int
	 */
	private $m_nExponent;
	/**
	 * @var int
	 */
	private $m_nISOCode;
	/**
	 * @var string
	 */
	private $m_szCurrency;
	/**
	 * @var string
	 */
	private $m_szCurrencyShort;

	//public properties
	/**
	 * @return int
	 */
	public function getExponent()
	{
		return $this -> m_nExponent;
	}
	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this -> m_szCurrency;
	}
	/**
	 * @return string
	 */
	public function getCurrencyShort()
	{
		return $this -> m_szCurrencyShort;
	}
	/**
	 * @return int
	 */
	public function getISOCode()
	{
		return $this -> m_nISOCode;
	}
	/**
	 * @param  int    $nAmount
	 * @param  bool   $boAppendCurrencyShort
	 * @return string
	 */
	public function getAmountCurrencyString($nAmount, $boAppendCurrencyShort = true)
	{
		$szReturnString = "";

		$nDivideAmount = pow(10, $this -> m_nExponent);
		$lfAmount = $nAmount / $nDivideAmount;

		$szFormatString = "%." . $this -> m_nExponent . "f";
		$szReturnString = sprintf($szFormatString, $lfAmount);

		if ($boAppendCurrencyShort)
		{
			$szReturnString = $szReturnString . " " . $this -> m_szCurrencyShort;
		}

		return ($szReturnString);
	}

	//constructor
	/**
	 * @param int    $nISOCode
	 * @param string $szCurrency
	 * @param string $szCurrencyShort
	 * @param int    $nExponent
	 */
	public function __construct($nISOCode, $szCurrency, $szCurrencyShort, $nExponent)
	{
		$this -> m_nISOCode = $nISOCode;
		$this -> m_nExponent = $nExponent;
		$this -> m_szCurrency = $szCurrency;
		$this -> m_szCurrencyShort = $szCurrencyShort;
	}

}
class ISOCurrencyList
{
	/**
	 * @var ISOCurrency[]
	 */
	private $m_licISOCurrencies;

	/**
	 * @param  string      $vCurrency     Currency short or ISO code
	 * @param  ISOCurrency $icISOCurrency
	 * @return bool
	 */
	public function getISOCurrency($vCurrency, &$icISOCurrency)
	{
		$boFound = false;
		$nCount = 0;
		$icISOCurrency2;

		$icISOCurrency = null;

		while (!$boFound && $nCount < count($this -> m_licISOCurrencies))
		{
			$icISOCurrency2 = $this -> m_licISOCurrencies[$nCount];

			if ($vCurrency == $icISOCurrency2 -> getCurrencyShort() || $vCurrency == $icISOCurrency2 -> getISOCode())
			{
				$icISOCurrency = new ISOCurrency($icISOCurrency2 -> getISOCode(), $icISOCurrency2 -> getCurrency(), $icISOCurrency2 -> getCurrencyShort(), $icISOCurrency2 -> getExponent());
				$boFound = true;
			}

			$nCount++;
		}

		return ($boFound);
	}
	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_licISOCurrencies);
	}
	/**
	 * @param  int         $nIndex
	 * @return ISOCurrency
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_licISOCurrencies))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_licISOCurrencies[$nIndex];
	}
	/**
	 * @param int    $nISOCode
	 * @param string $szCurrency
	 * @param string $szCurrencyShort
	 * @param int    $nExponent
	 */
	public function add($nISOCode, $szCurrency, $szCurrencyShort, $nExponent)
	{
		$newISOCurrency = new ISOCurrency($nISOCode, $szCurrency, $szCurrencyShort, $nExponent);

		$this -> m_licISOCurrencies[] = $newISOCurrency;
	}

	//constructor
	public function __construct()
	{
		$this -> m_licISOCurrencies = array();
	}

}
class XMLEntity
{
	/**
	 * @var int
	 */
	private $m_bCharCode;
	/**
	 * @var string
	 */
	private $m_szReplacement;

	/**
	 * @return int
	 */
	public function getCharCode()
	{
		return $this -> m_bCharCode;
	}
	/**
	 * @return string
	 */
	public function getReplacement()
	{
		return $this -> m_szReplacement;
	}

	//constructor
	/**
	 * @param int    $bCharCode     Hexadecimal character code
	 * @param string $szReplacement
	 */
	public function __construct($bCharCode, $szReplacement)
	{
		$this -> m_bCharCode = $bCharCode;
		$this -> m_szReplacement = $szReplacement;
	}

}
class XmlAttribute2
{
	/**
	 * @var string
	 */
	private $m_szName;
	/**
	 * @var string
	 */
	private $m_szValue;

	//public properties
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this -> m_szName;
	}
	/**
	 * @param string $szName
	 */
	public function setName($szName)
	{
		$this -> m_szName = $szName;
	}
	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this -> m_szValue;
	}
	/**
	 * @param string $szValue
	 */
	public function setValue($szValue)
	{
		$this -> m_szValue = $szValue;
	}
	/**
	 * @return XmlAttribute
	 */
	public function toXmlAttribute()
	{
		$xaXmlAttribute = new XmlAttribute($this -> m_szName, $this -> m_szValue);

		return $xaXmlAttribute;
	}

}
class XmlAttribute2List
{
	/**
	 * @var XmlAttribute2[]
	 */
	private $m_lxaXmlAttributeList;

	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lxaXmlAttributeList);
	}
	/**
	 * @param  int           $nIndex
	 * @return XmlAttribute2
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lxaXmlAttributeList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_lxaXmlAttributeList[$nIndex];
	}
	/**
	 * @param XmlAttribute2 $xaXmlAttribute
	 */
	public function add(XmlAttribute2 $xaXmlAttribute)
	{
		if ($xaXmlAttribute != null)
		{
			$this -> m_lxaXmlAttributeList[] = $xaXmlAttribute;
		}
	}

	//constructor
	public function __construct()
	{
		$this -> m_lxaXmlAttributeList = array();
	}

	/**
	 * @return XmlAttribute2[]
	 */
	public function toListOfXmlAttributeObjects()
	{
		$nCount = 0;
		$lxaXmlAttributeList = array();

		for ($nCount = 0; $nCount < count($this -> m_lxaXmlAttributeList); $nCount++)
		{
			$lxaXmlAttributeList[] = $this -> m_lxaXmlAttributeList[$nCount] -> toXmlAttribute();
		}

		return $lxaXmlAttributeList;
	}

}
class XmlTag2
{
	/**
	 * @var string
	 */
	private $m_szName;
	/**
	 * @var string
	 */
	private $m_szContent;
	/**
	 * @var XmlTag2List
	 */
	private $m_xtlChildTags;
	/**
	 * @var XmlAttribute2List
	 */
	private $m_xalXmlAttributes;

	//public properties
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this -> m_szName;
	}
	/**
	 * @param $szName
	 */
	public function setName($szName)
	{
		$this -> m_szName = $szName;
	}
	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this -> m_szContent;
	}
	/**
	 * @param string $szContent
	 */
	public function setContent($szContent)
	{
		$this -> m_szContent = $szContent;
	}
	/**
	 * @return XmlAttribute2List
	 */
	public function getXmlAttributes()
	{
		return $this -> m_xalXmlAttributes;
	}
	/**
	 * @return XmlTag2List
	 */
	public function getChildTags()
	{
		return $this -> m_xtlChildTags;
	}

	//constructor
	public function __construct()
	{
		$this -> m_xalXmlAttributes = new XmlAttribute2List();
		$this -> m_xtlChildTags = new XmlTag2List();
	}

	/**
	 * @return XmlTag
	 */
	public function toXmlTag()
	{
		$xtXmlTag = new XmlTag($this -> m_szName, $this -> m_szContent, $this -> m_xtlChildTags -> toListOfXmlTagObjects(), $this -> m_xalXmlAttributes -> toListOfXmlAttributeObjects());

		return $xtXmlTag;
	}

}
class XmlTag2List
{
	/**
	 * @var XMLTag2[]
	 */
	private $m_lxtXmlTagList;

	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lxtXmlTagList);
	}
	/**
	 * @param  int     $nIndex
	 * @return XMLTag2
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lxtXmlTagList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_lxtXmlTagList[$nIndex];
	}
	/**
	 * @param XmlTag2 $xtXmlTag
	 */
	public function add(XmlTag2 $xtXmlTag)
	{
		if ($xtXmlTag != null)
		{
			$this -> m_lxtXmlTagList[] = $xtXmlTag;
		}
	}

	//constructor
	public function __construct()
	{
		$this -> m_lxtXmlTagList = array();
	}

	/**
	 * @return XMLTag[]
	 */
	public function toListOfXmlTagObjects()
	{
		$nCount = 0;
		$lxtXmlTagList = array();

		for ($nCount = 0; $nCount < count($this -> m_lxtXmlTagList); $nCount++)
		{
			$lxtXmlTagList[] = $this -> m_lxtXmlTagList[$nCount] -> toXmlTag();
		}

		return $lxtXmlTagList;
	}

}
class XmlAttribute
{
	/**
	 * @var string
	 */
	private $m_szName;
	/**
	 * @var string
	 */
	private $m_szValue;

	//public properties
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this -> m_szName;
	}
	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this -> m_szValue;
	}

	//constructor
	/**
	 * @param  string    $szName
	 * @param  string    $szValue
	 * @throws Exception
	 */
	public function __construct($szName, $szValue)
	{
		if (!is_string($szName) || !is_string($szValue))
		{
			throw new Exception("Invalid parameter type");
		}

		$this -> m_szName = $szName;
		$this -> m_szValue = $szValue;
	}

}
class XmlAttributeList
{
	/**
	 * @var XmlAttribute2[]
	 */
	private $m_lxaXmlAttributeList;

	/**
	 * @param  string        $szName
	 * @return XmlAttribute2
	 */
	public function getXmlAttribute($szName)
	{
		$boFound = false;
		$nCount = 0;
		$xaXmlAttribute = null;
		$xaReturnXmlAttribute = null;

		while (!$boFound && $nCount < count($this -> m_lxaXmlAttributeList))
		{
			$xaXmlAttribute = $this -> m_lxaXmlAttributeList[$nCount];

			if ($szName == $xaXmlAttribute -> getName())
			{
				$xaReturnXmlAttribute = $xaXmlAttribute;
				$boFound = true;
			}

			$nCount++;
		}

		return $xaReturnXmlAttribute;
	}
	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lxaXmlAttributeList);
	}
	/**
	 * @param  int           $nIndex
	 * @return XmlAttribute2
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lxaXmlAttributeList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_lxaXmlAttributeList[$nIndex];
	}

	//constructor
	/**
	 * @param XmlAttribute2[] $lxaXmlAttributeList
	 */
	public function __construct($lxaXmlAttributeList)
	{
		$nCount = 0;

		$this -> m_lxaXmlAttributeList = array();

		if ($lxaXmlAttributeList != null)
		{
			try
			{
				for ($nCount = 0; $nCount < count($lxaXmlAttributeList); $nCount++)
				{
					$this -> m_lxaXmlAttributeList[] = $lxaXmlAttributeList[$nCount];
				}
			}
			catch(Exception $e)
			{
			}
		}
	}

	/**
	 * @return XmlAttribute2[]
	 */
	public function getListOfXmlAttributeObjects()
	{
		$nCount = 0;
		$lxaXmlAttributeList = array();

		for ($nCount = 0; $nCount < count($this -> m_lxaXmlAttributeList); $nCount++)
		{
			$lxaXmlAttributeList[] = $this -> m_lxaXmlAttributeList[$nCount];
		}

		return $lxaXmlAttributeList;
	}

}
class XmlTag
{
	/**
	 * @var string
	 */
	private $m_szName;
	/**
	 * @var string
	 */
	private $m_szContent;
	/**
	 * @var XmlTagList
	 */
	private $m_xtlChildTags;
	/**
	 * @var XmlAttributeList
	 */
	private $m_xalXmlAttributes;

	//public properties
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this -> m_szName;
	}
	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this -> m_szContent;
	}
	/**
	 * @return XmlAttributeList
	 */
	public function getXmlAttributes()
	{
		return $this -> m_xalXmlAttributes;
	}
	/**
	 * @return XmlTagList
	 */
	public function getChildTags()
	{
		return $this -> m_xtlChildTags;
	}
	/**
	 * @param  string $szXMLVariable
	 * @param  string $szValue
	 * @return bool
	 */
	public function getStringValue($szXMLVariable, &$szValue)
	{
		$boReturnValue = false;

		$szValue = "";

		if ($this -> m_xtlChildTags != null)
		{
			$boReturnValue = $this -> m_xtlChildTags -> getValue($szXMLVariable, $szValue);
		}

		return ($boReturnValue);
	}
	/**
	 * @param  string $szXMLVariable
	 * @param  int    $nValue
	 * @return bool
	 */
	public function getIntegerValue($szXMLVariable, &$nValue)
	{
		$boReturnValue = false;
		$szValue = "";

		$nValue = false;
		if ($this -> m_xtlChildTags != null)
		{
			$boReturnValue = $this -> m_xtlChildTags -> getValue($szXMLVariable, $szValue);

			if ($boReturnValue)
			{
				if (!is_numeric($szValue))
				{
					$boReturnValue = false;
				}
				else
				{
					try
					{
						$nValue = intval($szValue);
					}
					catch (Exception $e)
					{
						$boReturnValue = false;
					}
				}
			}
		}

		return ($boReturnValue);
	}
	/**
	 * @param  string $szXMLVariable
	 * @param  bool   $boValue
	 * @return bool
	 */
	public function getBooleanValue($szXMLVariable, &$boValue)
	{
		$boReturnValue = false;
		$szValue = "";

		$boValue = false;
		if ($this -> m_xtlChildTags != null)
		{
			$boReturnValue = $this -> m_xtlChildTags -> getValue($szXMLVariable, $szValue);

			if ($boReturnValue)
			{
				if ($szValue != "0" && $szValue != "1" && strtoupper($szValue) != "FALSE" && strtoupper($szValue) != "TRUE")
				{
					$boReturnValue = false;
				}
				else
				{
					if (strtoupper($szValue) == "TRUE" || $szValue == "1")
					{
						$boValue = true;
					}
				}
			}
		}

		return ($boReturnValue);
	}

	//constructor
	/**
	 * @param string          $szName
	 * @param string          $szContent
	 * @param XMLTag[]        $lxtChildTags
	 * @param XMLAttribute2[] $lxaXmlAttributes
	 */
	public function __construct($szName, $szContent, $lxtChildTags, $lxaXmlAttributes)
	{
		$this -> m_szName = $szName;
		$this -> m_szContent = $szContent;
		$this -> m_xalXmlAttributes = new XmlAttributeList($lxaXmlAttributes);
		$this -> m_xtlChildTags = new XmlTagList($lxtChildTags);
	}

}
class XmlTagList
{
	/**
	 * @var XMLTag[]
	 */
	private $m_lxtXmlTagList;

	/**
	 * @return int
	 */
	public function getCount()
	{
		return count($this -> m_lxtXmlTagList);
	}
	/**
	 * @param  int       $nIndex
	 * @return XmlTag
	 * @throws Exception
	 */
	public function getAt($nIndex)
	{
		if ($nIndex < 0 || $nIndex >= count($this -> m_lxtXmlTagList))
		{
			throw new Exception("Array index out of bounds");
		}

		return $this -> m_lxtXmlTagList[$nIndex];
	}
	/**
	 * @param  string    $szName
	 * @return XmlTag
	 * @throws Exception
	 */
	public function getXmlTag($szName)
	{
		$lszHierarchicalNames = null;
		$nCount = 0;
		$boAbort = false;
		$boFound = false;
		$boLastNode = false;
		$szString;
		$szTagNameToFind;
		$nCurrentIndex = 0;
		$xtReturnTag = null;
		$xtCurrentTag = null;
		$nTagCount = 0;
		$xtlCurrentTagList = null;
		$nCount2 = 0;

		if (count($this -> m_lxtXmlTagList) == 0)
		{
			return null;
		}

		$lszHierarchicalNames = new StringList();
		$lszHierarchicalNames = SharedFunctions::getStringListFromCharSeparatedString($szName, '.');

		$xtlCurrentTagList = $this;

		// loop over the hierarchical list
		for ($nCount = 0; $nCount < $lszHierarchicalNames -> getCount() && !$boAbort; $nCount++)
		{
			if ($nCount == ($lszHierarchicalNames -> getCount() - 1))
			{
				$boLastNode = true;
			}

			$szString = $lszHierarchicalNames -> getAt($nCount);

			// look to see if this tag name has the special "[]" array chars
			$szTagNameToFind = SharedFunctions::getArrayNameAndIndex($szString, $nCurrentIndex);

			$boFound = false;
			$nCount2 = 0;

			for ($nTagCount = 0; $nTagCount < $xtlCurrentTagList -> getCount() && !$boFound; $nTagCount++)
			{
				$xtCurrentTag = $xtlCurrentTagList -> getAt($nTagCount);

				// if this is the last node then check the attributes of the tag first

				if ($xtCurrentTag -> getName() == $szTagNameToFind)
				{
					if ($nCount2 == $nCurrentIndex)
					{
						$boFound = true;
					}
					else
					{
						$nCount2++;
					}
				}

				if ($boFound)
				{
					if (!$boLastNode)
					{
						$xtlCurrentTagList = $xtCurrentTag -> getChildTags();
					}
					else
					{
						// don't continue the search
						$xtReturnTag = $xtCurrentTag;
					}
				}
			}

			if (!$boFound)
			{
				$boAbort = true;
			}
		}

		return $xtReturnTag;
	}
	/**
	 * @param  string    $szXMLVariable
	 * @param  string    $szValue       Passed by reference
	 * @return bool
	 * @throws Exception
	 */
	public function getValue($szXMLVariable, &$szValue)
	{
		$boReturnValue = false;
		$lszHierarchicalNames;
		$szXMLTagName;
		$szLastXMLTagName;
		$nCount = 0;
		$xtCurrentTag = null;
		$xaXmlAttribute = null;

		$lszHierarchicalNames = new StringList();
		$szValue = null;
		$lszHierarchicalNames = SharedFunctions::getStringListFromCharSeparatedString($szXMLVariable, '.');

		if ($lszHierarchicalNames -> getCount() == 1)
		{
			$szXMLTagName = $lszHierarchicalNames -> getAt(0);

			$xtCurrentTag = $this -> getXmlTag($szXMLTagName);

			if ($xtCurrentTag != null)
			{
				$xaXmlAttribute = $xtCurrentTag -> getXmlAttributes() -> getXmlAttribute($szXMLTagName);

				if ($xaXmlAttribute != null)
				{
					$szValue = SharedFunctions::replaceEntitiesInStringWithChars($xaXmlAttribute -> getValue());
					$boReturnValue = true;
				}
				else
				{
					$szValue = SharedFunctions::replaceEntitiesInStringWithChars($xtCurrentTag -> getContent());
					$boReturnValue = true;
				}
			}
		}
		else
		{
			if ($lszHierarchicalNames -> getCount() > 1)
			{
				$szXMLTagName = $lszHierarchicalNames -> getAt(0);
				$szLastXMLTagName = $lszHierarchicalNames -> getAt($lszHierarchicalNames -> getCount() - 1);

				// need to remove the last variable from the passed name
				for ($nCount = 1; $nCount < ($lszHierarchicalNames -> getCount() - 1); $nCount++)
				{
					$szXMLTagName .= "." . $lszHierarchicalNames -> getAt($nCount);
				}

				$xtCurrentTag = $this -> getXmlTag($szXMLTagName);

				// first check the attributes of this tag
				if ($xtCurrentTag != null)
				{
					$xaXmlAttribute = $xtCurrentTag -> getXmlAttributes() -> getXmlAttribute($szLastXMLTagName);

					if ($xaXmlAttribute != null)
					{
						$szValue = SharedFunctions::replaceEntitiesInStringWithChars($xaXmlAttribute -> getValue());
						$boReturnValue = true;
					}
					else
					{
						// check to see if it's actually a tag
						if ($xtCurrentTag -> getChildTags() != null)
						{
							$xtCurrentTag = $xtCurrentTag -> getChildTags() -> getXmlTag($szLastXMLTagName);

							if ($xtCurrentTag != null)
							{
								$szValue = SharedFunctions::replaceEntitiesInStringWithChars($xtCurrentTag -> getContent());
								$boReturnValue = true;
							}
						}
					}
				}
			}
		}

		return ($boReturnValue);
	}

	//constructor
	/**
	 * @param XMLTag[] $lxtXmlTagList
	 */
	public function __construct($lxtXmlTagList)
	{
		$nCount = 0;

		$this -> m_lxtXmlTagList = array();

		if ($lxtXmlTagList != null)
		{
			try
			{
				for ($nCount = 0; $nCount < count($lxtXmlTagList); $nCount++)
				{
					$this -> m_lxtXmlTagList[] = $lxtXmlTagList[$nCount];
				}
			}
			catch(Exception $e)
			{
			}
		}
	}

	/**
	 * @return XMLTag[]
	 */
	public function getListOfXmlTagObjects()
	{
		$nCount = 0;
		$lxtXmlTagList = array();

		for ($nCount = 0; $nCount < count($this -> m_lxtXmlTagList); $nCount++)
		{
			$lxtXmlTagList[] = $this -> m_lxtXmlTagList[$nCount];
		}

		return $lxtXmlTagList;
	}

}
class XmlParser
{
	/**
	 * @var XmlTagList
	 */
	private $m_xtlXmlTagList;

	/**
	 * @param  string $szXMLVariable
	 * @param  string $szValue
	 * @return bool
	 */
	public function getStringValue($szXMLVariable, &$szValue)
	{
		$boReturnValue = false;

		$szValue = "";

		if ($this -> m_xtlXmlTagList != null)
		{
			$boReturnValue = $this -> m_xtlXmlTagList -> getValue($szXMLVariable, $szValue);
		}

		return ($boReturnValue);
	}
	/**
	 * @param  string $szXMLVariable
	 * @param  int    $nValue
	 * @return bool
	 */
	public function getIntegerValue($szXMLVariable, &$nValue)
	{
		$boReturnValue = false;
		$szValue = "";

		$nValue = false;
		if ($this -> m_xtlXmlTagList != null)
		{
			$boReturnValue = $this -> m_xtlXmlTagList -> getValue($szXMLVariable, $szValue);

			if ($boReturnValue)
			{
				if (!is_numeric($szValue))
				{
					$boReturnValue = false;
				}
				else
				{
					try
					{
						$nValue = intval($szValue);
					}
					catch (Exception $e)
					{
						$boReturnValue = false;
					}
				}
			}
		}

		return ($boReturnValue);
	}
	/**
	 * @param  string $szXMLVariable
	 * @param  bool   $boValue
	 * @return bool
	 */
	public function getBooleanValue($szXMLVariable, &$boValue)
	{
		$boReturnValue = false;
		$szValue = "";

		$boValue = false;
		if ($this -> m_xtlXmlTagList != null)
		{
			$boReturnValue = $this -> m_xtlXmlTagList -> getValue($szXMLVariable, $szValue);

			if ($boReturnValue)
			{
				if ($szValue != "0" && $szValue != "1" && strtoupper($szValue) != "FALSE" && strtoupper($szValue) != "TRUE")
				{
					$boReturnValue = false;
				}
				else
				{
					if (strtoupper($szValue) == "TRUE" || $szValue == "1")
					{
						$boValue = true;
					}
				}
			}
		}

		return ($boReturnValue);
	}
	/**
	 * @param  string $szTagName
	 * @return XMLTag
	 */
	public function getTag($szTagName)
	{
		$xmlReturnTag = null;

		if ($this -> m_xtlXmlTagList -> getCount() == 0)
		{
			return (null);
		}

		$xmlReturnTag = $this -> m_xtlXmlTagList -> getXmlTag($szTagName);

		return ($xmlReturnTag);
	}
	/**
	 * @param  string $szXmlString
	 * @return bool
	 */
	public function parseBuffer($szXmlString)
	{
		$boReturnValue = false;

		try
		{
			$sxiSimpleXMLIterator = new SimpleXMLIterator($szXmlString);

			$xtlXmlTagList = XmlParser::toXmlTagList($sxiSimpleXMLIterator);
			$this -> m_xtlXmlTagList = new XmlTagList($xtlXmlTagList -> toListOfXmlTagObjects());

			$boReturnValue = true;
		}
		catch (Exception $e)
		{
		}

		return $boReturnValue;
	}
	/**
	 * @param  SimpleXMLIterator $sxiSimpleXMLIterator
	 * @return XmlTag2List
	 * @throws Exception
	 */
	private static function toXmlTagList(SimpleXMLIterator $sxiSimpleXMLIterator)
	{
		$xtlXmlTagList = new XmlTag2List();

		for ($sxiSimpleXMLIterator -> rewind(); $sxiSimpleXMLIterator -> valid(); $sxiSimpleXMLIterator -> next())
		{
			$xtXmlTag = new XmlTag2();
			$xtlXmlTagList -> add($xtXmlTag);
			$xtXmlTag -> setName($sxiSimpleXMLIterator -> key());

			if (strval($sxiSimpleXMLIterator -> current()) != "")
			{
				$xtXmlTag -> setContent(strval($sxiSimpleXMLIterator -> current()));
			}

			// get the attributes
			foreach ($sxiSimpleXMLIterator->current()->attributes() as $szName => $szValue)
			{
				$xaXmlAttribute = new XmlAttribute2();
				$xaXmlAttribute -> setName($szName);
				$xaXmlAttribute -> setValue(strval($szValue));
				$xtXmlTag -> getXmlAttributes() -> add($xaXmlAttribute);
			}

			// parse the child tags
			if ($sxiSimpleXMLIterator -> hasChildren())
			{
				$xtlChildXmlTagList = XmlParser::toXmlTagList($sxiSimpleXMLIterator -> current());

				for ($nCount = 0; $nCount < $xtlChildXmlTagList -> getCount(); $nCount++)
				{
					$xtXmlTag -> getChildTags() -> add($xtlChildXmlTagList -> getAt($nCount));
				}
			}
		}

		return $xtlXmlTagList;
	}

}
class SharedFunctions
{
	/**
	 * @param  string    $szString
	 * @param  string    $cDelimiter
	 * @return StringList
	 * @throws Exception
	 */
	public static function getStringListFromCharSeparatedString($szString, $cDelimiter)
	{
		$nCount = 0;
		$nLastCount = -1;
		$szSubString;
		$nStringLength;
		$lszStringList;

		if ($szString == null || $szString == "" || (string)$cDelimiter == "")
		{
			return null;
		}

		$lszStringList = new StringList();

		$nStringLength = strlen($szString);

		for ($nCount = 0; $nCount < $nStringLength; $nCount++)
		{
			if ($szString[$nCount] == $cDelimiter)
			{
				$szSubString = substr($szString, ($nLastCount + 1), ($nCount - $nLastCount - 1));
				$nLastCount = $nCount;
				$lszStringList -> add($szSubString);

				if ($nCount == $nStringLength)
				{
					$lszStringList -> add("");
				}
			}
			else
			{
				if ($nCount == ($nStringLength - 1))
				{
					$szSubString = substr($szString, ($nLastCount + 1), ($nCount - $nLastCount));
					$lszStringList -> add($szSubString);
				}
			}
		}

		return $lszStringList;
	}
	/**
	 * @param  string $szName
	 * @param  int    $nIndex Passed by reference
	 * @return string
	 */
	public static function getArrayNameAndIndex($szName, &$nIndex)
	{
		$szReturnString;
		$nCount = 0;
		$szSubString;
		$boFound = false;
		$boAbort = false;
		$boAtLeastOneDigitFound = false;

		if ($szName == "")
		{
			$nIndex = 0;
			return $szName;
		}

		$szReturnString = $szName;
		$nIndex = 0;

		if ($szName[(strlen($szName) - 1)] == ']')
		{
			$nCount = strlen($szName) - 2;

			while (!$boFound && !$boAbort && $nCount >= 0)
			{
				// if we've found the closing array brace
				if ($szName[$nCount] == '[')
				{
					$boFound = true;
				}
				else
				{
					if (!is_numeric($szName[$nCount]))
					{
						$boAbort = true;
					}
					else
					{
						$boAtLeastOneDigitFound = true;
						$nCount--;
					}
				}
			}

			// did we finish successfully?
			if ($boFound && $boAtLeastOneDigitFound)
			{
				$szSubString = substr($szName, ($nCount + 1), (strlen($szName) - $nCount - 2));
				$szReturnString = substr($szName, 0, $nCount);
				$nIndex = (int)($szSubString);
			}
		}

		return $szReturnString;
	}
	/**
	 * @param  string $str
	 * @return string
	 */
	public static function stringToByteArray($str)
	{
		$encoded;

		$encoded = utf8_encode($str);

		return $encoded;
	}
	/**
	 * @param  string  $aByte
	 * @return string
	 */
	public static function byteArrayToString($aByte)
	{
		return utf8_decode($aByte);
	}
	/**
	 * @param  int    $nNumber
	 * @param  int    $nPaddingAmount
	 * @param  string $cPaddingChar
	 * @return string
	 */
	public static function forwardPaddedNumberString($nNumber, $nPaddingAmount, $cPaddingChar)
	{
		$szReturnString;
		$sbString;
		$nCount = 0;

		$szReturnString = (string)$nNumber;

		if (strlen($szReturnString) < $nPaddingAmount && $nPaddingAmount > 0)
		{
			$sbString = "";

			for ($nCount = 0; $nCount < ($nPaddingAmount - strlen($szReturnString)); $nCount++)
			{
				$sbString .= $cPaddingChar;
			}

			$sbString .= $szReturnString;
			$szReturnString = (string)$sbString;
		}

		return $szReturnString;
	}
	/**
	 * @param  string $szString
	 * @return string
	 */
	public static function stripAllWhitespace($szString)
	{
		$sbReturnString;
		$nCount = 0;

		if ($szString == null)
		{
			return (null);
		}

		$sbReturnString = "";

		for ($nCount = 0; $nCount < strlen($szString); $nCount++)
		{
			if ($szString[$nCount] != ' ' && $szString[$nCount] != '\t' && $szString[$nCount] != '\n' && $szString[$nCount] != '\r')
			{
				$sbReturnString .= $szString[$nCount];
			}
		}

		return (string)$sbReturnString;
	}
	/**
	 * @param  string $szString
	 * @return bool
	 */
	public static function isStringNullOrEmpty($szString)
	{
		$boReturnValue = false;

		if ($szString == null || $szString == "")
		{
			$boReturnValue = true;
		}

		return ($boReturnValue);
	}
	/**
	 * @param  string      $szString
	 * @return null|string
	 */
	public static function replaceCharsInStringWithEntities($szString)
	{
		//give access to enum like associated array
		global $g_XMLEntities;

		$szReturnString;
		$nCount;
		$boFound;
		$nHTMLEntityCount;

		$szReturnString = null;

		for ($nCount = 0; $nCount < strlen($szString); $nCount++)
		{
			$boFound = false;
			$nHTMLEntityCount = 0;

			while (!$boFound && $nHTMLEntityCount < count($g_XMLEntities))
			{
				//$test1 = htmlspecialchars('&');

				if ($g_XMLEntities[$nHTMLEntityCount] -> getReplacement() == htmlspecialchars($szString[$nCount]))
				{
					$boFound = true;
				}
				else
				{
					$nHTMLEntityCount++;
				}
			}

			if ($boFound)
			{
				$szReturnString .= $g_XMLEntities[$nHTMLEntityCount] -> getReplacement();
			}
			else
			{
				$szReturnString .= $szString[$nCount];
			}
		}

		return $szReturnString;
	}
	/**
	 * @param  string      $szString
	 * @return null|string
	 */
	public static function replaceEntitiesInStringWithChars($szString)
	{
		$szReturnString = null;
		$nCount;
		$boFound = false;
		$boFoundAmpersand = false;
		$nHTMLEntityCount;
		$szAmpersandBuffer = "";
		$nAmpersandBufferCount = 0;

		for ($nCount = 0; $nCount < strlen($szString); $nCount++)
		{
			$boFound = false;
			$nHTMLEntityCount = 0;

			if (!$boFoundAmpersand)
			{
				if ($szString[$nCount] == '&')
				{
					$boFoundAmpersand = true;
					$szAmpersandBuffer = (string)$szString[$nCount];
					$nAmpersandBufferCount = 0;
				}
				else
				{
					$szReturnString .= $szString[$nCount];
				}
			}
			else
			{
				$szAmpersandBuffer .= $szString[$nCount];

				if ($nAmpersandBufferCount < (10 - 2))
				{
					if ($szString[$nCount] == ';')
					{
						$boFound = true;
						$boFoundAmpersand = false;
					}
					else
					{
						$nAmpersandBufferCount++;
					}
				}
				else
				{
					$szReturnString .= $szAmpersandBuffer;
					$boFoundAmpersand = false;
				}
			}

			if ($boFound)
			{
				// need to find the entity in the list
				$boFoundEntity = false;
				$nXMLEntityCount = 0;

				while (!$boFoundEntity && $nXMLEntityCount < count($g_XMLEntities))
				{
					if (strtoupper($g_XMLEntities[$nXMLEntityCount] -> getReplacement()) == strtoupper($szAmpersandBuffer))
					{
						$boFoundEntity = true;
					}
					else
					{
						$nXMLEntityCount++;
					}
				}

				if ($boFoundEntity)
				{
					$szReturnString .= $g_XMLEntities[$nXMLEntityCount] -> getCharCode();
				}
				else
				{
					$szReturnString .= $szAmpersandBuffer;
				}
				$boFound = false;
			}
		}

		if ($boFoundAmpersand && !$boFound)
		{
			$szReturnString .= $szAmpersandBuffer;
		}

		return $szReturnString;
	}
	/**
	 * @param  bool   $boValue
	 * @return string
	 */
	public static function boolToString($boValue)
	{
		if ($boValue == true)
		{
			return "true";
		}
		elseif ($boValue == false)
		{
			return "false";
		}
	}

}