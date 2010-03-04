var theIP = new IpAddress();
theIP.setTextValue('192.168.0.1');

var theMask = new NetMask();
theMask.setTextValue('255.255.255.0');

var testIP = new IpAddress();

window.onload=function() {
 getObj('ipMainForm').innerHTML = theIP;
 getObj('maskMainForm').innerHTML = theMask;
 getObj('copyright').innerHTML += '<a href="mailto:'+'balestra'+'@cesmail.net">'+'Marco Balestra</a>';
 updateInfos();
}

function updateInfos() {
 var i,by,bit,netclass;
 var sml = theMask.getMaskLength();
 var invalidMask = '<b>INVALID</b>';
 getObj('ipClassicValue').innerHTML = theIP.getIpText()+'/'+(sml ? theMask.getIpText() : invalidMask);
 getObj('ipCiscoValue').innerHTML = theIP.getIpText()+'/'+(sml ? sml : invalidMask);
 getObj('ipBinaryValue').innerHTML = theIP.getBinaryText();
 getObj('maskBinaryValue').innerHTML = sml ? theMask.getBinaryText() : invalidMask;
 testIP.setTextValue(theIP.getIpText());
 if ((sml) && (sml < 31)) {
  for (i=sml; i<32; i++) {
   bit = i % 8;
   by = (i - bit) /8;
   testIP.bytes[3 - by].bits[7 - bit].setValue(0);
  }
  getObj('networkRange').innerHTML = testIP.getIpText()+'/'+(sml ? sml : invalidMask);
  getObj('networkValue').innerHTML = sml ? testIP.getIpText() : invalidMask;
  for (i=sml; i<32; i++) {
   bit = i % 8;
   by = (i - bit) /8;
   testIP.bytes[3 - by].bits[7 - bit].setValue(1);
  }
  getObj('broadcastValue').innerHTML = (sml ? testIP.getIpText() : invalidMask);
 } else {
  getObj('networkRange').innerHTML = '';
  getObj('networkValue').innerHTML = '';
  getObj('broadcastValue').innerHTML = '';
 }
 getObj('networkClass').innerHTML = getNetClass(sml);
 if (sml) {
  by = 1;
  for (i=0; i<(32 -sml); i++) by = by * 2;
  getObj('availableIPs').innerHTML = by;
 } else {
  getObj('availableIPs').innerHTML = '';
 }
}

function getNetClass(x) {
 if (x) {
  if (x > 28) return '';
  if (x == 28) return 'D';
  if (x > 24) return 'subnet of C';
  if (x == 24) return 'C';
  if (x > 16) return 'subnet of B';
  if (x == 16) return 'B';
  if (x > 8) return 'subnet of A';
  if (x == 8) return 'A';
  if (x > 0) return 'unknown';
 } else {
  return '';
 }
}

function showHideInfo() {
 var i = getObj('otherinfo');
 if (i) if (i.style) i.style.display = i.style.display == 'block' ? 'none' : 'block';
 return void(0);
}
