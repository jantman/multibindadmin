var internal__ipsCollection = [];

function getObj(x) {
 if (document.getElementById) return (document.getElementById(x)) ? document.getElementById(x) : false;
 return false;
}

function updateInfos() {}

function IpAddress(val) {
 this.internalIndex = internal__ipsCollection.length;
 this.getIndex      = function(){ return this.internalIndex };
 this.internalType  = 'ip';
 this.name          = 'internal__ipObj'+this.internalIndex;
 this.bytes         = [];
 this.getIpText     = function(){ return this.bytes[3].getText()+'.'+this.bytes[2].getText()+'.'+this.bytes[1].getText()+'.'+this.bytes[0].getText() };
 this.getBinaryText = function(){ return this.bytes[3].getBitsString()+'.'+this.bytes[2].getBitsString()+'.'+this.bytes[1].getBitsString()+'.'+this.bytes[0].getBitsString() };
 this.getName       = function(){ return this.name };
 this.getText       = function(){ return this.getValue().toString() };
 this.getType       = function(){ return this.internalType };
 this.getValue      = function(){ return this.bytes[0].getValue()+2*(this.bytes[1].getValue()+2*(this.bytes[2].getValue()+2*this.bytes[3].getValue())) };
 this.setValue      = internal__IPAddress__setIpAddressValue;
 this.setTextValue  = internal__IPAddress__setIpAddressTextValue;
 this.getHtmlForm   = function(){ return '<div class="ipform" id="'+this.getName()+'_form">'+this.bytes[3].getHtmlFullForm()+this.bytes[2].getHtmlFullForm()+this.bytes[1].getHtmlFullForm()+this.bytes[0].getHtmlFullForm()+'</div>' };
 this.toString      = this.getHtmlForm;
 internal__ipsCollection[this.internalIndex] = this;
 internal__IPAddress__initializeBytes(this, (val) ? parseInt(val) : 0);
 return this;
}

function NetMask(val) {
 var x           = new IpAddress(val);
 x.internalType  = 'mask';
 x.setNetMask    = internal__NetMask__setNetMask;
 x.getMaskLength = internal__NetMask__getNetMaskLength;
 return x;
}

function Byte(ip,val) {
 this.ip               = ip;
 this.internalIndex    = this.ip.bytes.length;
 this.getIndex         = function(){ return this.internalIndex };
 this.name             = this.ip.getName() + '_byte' + this.internalIndex;
 this.getName          = function(){ return this.name };
 this.bits             = [];
 this.setValue         = internal__Byte__setByteValue;
 this.getIp            = function(){ return this.ip };
 this.getText          = function(){ return this.getValue().toString() };
 this.getValue         = internal__Byte__getValueFromBits;
 this.getBitsArray     = function(){ return this.bits };
 this.getBitsString    = function(){ var risp = ''; for (var i=7; i>-1; i--) risp += this.bits[i].getText(); return risp };
 this.getHtmlEditField = function(){ return '<input id="'+this.getName()+'_edit" type="text" class="byte" value="'+this.getText()+'" onchange="internal__ipsCollection['+this.ip.getIndex()+'].bytes['+this.getIndex()+'].updateByEdit()" size="3" />' };
 this.getHtmlBitsField = function(){ var i,a=[]; for(i=0;i<8;i++)a[i]=this.bits[7-i].getHtmlButton(); return a.join("\n") };
 this.getHtmlFullForm  = function(){ return '<div class="byteform"><div class="byteedit">'+this.getHtmlEditField()+'</div><div class="bytebits">'+this.getHtmlBitsField()+'</div></div>' };
 this.updateHtml       = function(){ var x=getObj(this.getName()+'_edit'); if (x) x.value = this.getText() };
 this.updateByEdit     = function(){ this.setValue(parseInt(getObj(this.getName()+'_edit').value)); for (var i=0; i<7; i++) this.bits[i].updateHtml(); updateInfos() };
 this.ip.bytes[this.internalIndex] = this;
 internal__Byte__initializeBits(this, (val) ? parseInt(val) : 0);
 return this;
}

function Bit(by,val) {
 this.by            = by;
 this.internalIndex = this.by.bits.length;
 this.getIndex      = function(){ return this.internalIndex };
 this.name          = this.by.getName() + '_bit' + this.internalIndex;
 this.getName       = function(){ return this.name };
 this.value         = (val) ? parseInt(val) % 2 : 0;
 this.getByte       = function(){ return this.by };
 this.getText       = function(){ return this.value.toString() };
 this.getValue      = function(){ return parseInt(this.value) };
 this.getReverse    = function(){ return this.value == 0 ? 1 : 0 };
 this.setValue      = function(v){ this.value = parseInt(v) % 2; this.updateHtml(); return this.value };
 this.setReverse    = function(){ this.setValue(this.getReverse()); this.updateHtml(); this.by.updateHtml(); updateInfos() };
 this.getHtmlButton = internal__Bit__getHtmlButton;
 this.updateHtml    = function(){ var x=getObj(this.getName()); if (x) x.innerHTML = this.getText(); };
 this.by.bits[this.internalIndex] = this;
 return this;
}


function internal__IPAddress__initializeBytes(ip,v) {
 var r,risp = new Array(4);
 for (var i=0; i<4; i++) {
  r = v % 256;
  v = parseInt((v -r)/256);
  new Byte(ip,r);
 }
}

function internal__NetMask__setNetMask(by,bit) {
 for (var i=0; i<4; i++) {
  if (i==by) {
   for (var j=0; j<8; j++) {
     this.bytes[i].bits[j].setValue( j < bit ? 0 : 1 );
   }
   this.bytes[i].updateHtml();
  } else {
   this.bytes[i].setValue( i < by ? 0 : 255 );
   this.bytes[i].updateByEdit();
  }
 }
}

function internal__IPAddress__setIpAddressValue(v) {
 var i,r;
 for (i=0; i<4; i++) {
  r = v % 256;
  v = parseInt((v -r)/256);
  this.bytes[i].setValue(r);
 }
}

function internal__IPAddress__setIpAddressTextValue(t) {
 var b = t.toString().split('.');
 for (var i=0; i<4; i++) this.bytes[3 -i].setValue(parseInt(b[i]));
}

function internal__Byte__initializeBits(by,v) {
 var r,risp = new Array(8);
 for (var i=0; i<8; i++) {
  r = v % 2;
  v = parseInt((v -r)/2);
  new Bit(by,r);
 }
}

function internal__Byte__setByteValue(val) {
 var i,r;
 for(i=0; i<8; i++) {
  r = val % 2;
  val = parseInt((val - r)/2);
  this.bits[i].setValue(r);
 }
 this.updateHtml();
}

function internal__Byte__getTextFromBits() { return this.getValue().toString() }

function internal__Byte__getValueFromBits() {
 var tot = 0, peso = 1;
 for (var i=0; i<8; i++) {
  tot += parseInt( this.bits[i].getValue() * peso );
  peso = peso *2;
 }
 return tot;
}

function internal__Byte__getBitsString() {
 var risp = ''; for (var i=7; i>-1; i--) risp += this.bits[i].getText(); return risp;
}

function internal__Bit__getHtmlButton() {
 var by = this.getByte();
 var ip = by.getIp();
 var ipt = ip.getType()
 var risp = '<div id="'+this.getName()+'" class="bit" onclick="';
 if (ipt == 'ip') risp += "internal__ipsCollection["+ip.getIndex()+"].bytes["+by.getIndex()+"].bits["+this.getIndex()+"].setReverse();";
 if (ipt == 'mask') risp += "internal__ipsCollection["+ip.getIndex()+"].setNetMask("+by.getIndex()+","+this.getIndex()+");";
 risp += '">'+this.getText()+'</div>';
 return risp;
}

function internal__NetMask__getNetMaskLength() {
 var bs=this.bytes;
 var invert = -1;
 var tot = 0;
 var prev = -1;
 var bit = 0;
 for (var i=3; i>-1; i--) {
  for (var j=7; j>-1; j--) {
   bit = bs[i].bits[j].getValue();
   tot += bit;
   if (prev != bit) invert++;
   prev = bit;
  }
 }
 return invert > 1 ? false : tot;
}
