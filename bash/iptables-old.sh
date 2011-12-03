#!/bin/bash

#####################################################
# Firewall-Script fuer IPTABLES (ab Kernel 2.4)
# thrstnh
# thrstn.hllbrnd _at_ googlemail.com
# entworfen: Mitte 2002
#####################################################

LO="lo"
LO_IP="127.0.0.1"
LAN_IP="192.168.100.1"
INT="eth0"
EXT="ppp0"
IPT="iptables"
ANY="0/0"
CLIENT="192.168.100.1"
FTP="20:21"
SSH="22"
HTTP="80"
WSGI="6666"
CVS="2401"
SVN="3690"
MYSQL="3306"
ICQ_MSG_PORT="5190"
ICQ_FT_PORTS="24500:24510"
CSS="27960"
OPENARENA="27960"
PORT_ALL="1:65535"
PORT_LOW="1:1023"
PORT_HIGH="1024:65535"

##### Alte Regeln loeschen #####
$IPT -F
$IPT -t nat -F
$IPT -t mangle -F
$IPT -X
$IPT -t nat -X
$IPT -t mangle -X

##### Default ######
$IPT -P INPUT DROP
$IPT -P OUTPUT DROP
$IPT -P FORWARD DROP

##### Kerneldienste aktivieren #####
echo "1" > /proc/sys/net/ipv4/ip_forward
echo "1" > /proc/sys/net/ipv4/ip_dynaddr

##### Defekte Pakete loeschen #####
$IPT -A INPUT -m state --state INVALID -j DROP
$IPT -A OUTPUT -m state --state INVALID -j DROP
$IPT -A FORWARD -m state --state INVALID -j DROP

##### Chains anlegen #####
$IPT -N packets_accept
$IPT -N tcp_accept
$IPT -N udp_accept
$IPT -N icmp_accept

##### packets_accept Chain #####
$IPT -A packets_accept -p tcp --syn -j ACCEPT
$IPT -A packets_accept -p tcp -m state --state ESTABLISHED,RELATED -j ACCEPT
$IPT -A packets_accept -p tcp -j DROP

##### tcp_accept Chain #####
$IPT -A tcp_accept -p tcp -s $ANY -m multiport --dport $FTP,$SSH,$HTTP,$WSGI,,$CSS,$CVS,$SVN -j packets_accept

##### udp_accept Chain #####
$IPT -A udp_accept -p udp -s $ANY -m multiport --dport 53,$MYSQL -j ACCEPT

##### icmp_accept Chain #####
$IPT -A icmp_accept -p icmp -s $ANY -j ACCEPT

##### Loopbackregeln #####
$IPT -A INPUT -i $LO -s $LO_IP -j ACCEPT
$IPT -A OUTPUT -o $LO -d $LO_IP -j ACCEPT

##### LAN freigeben #####
$IPT -A INPUT -i $INT -j ACCEPT
$IPT -A OUTPUT -o $INT -j ACCEPT
$IPT -A FORWARD -i $INT -j ACCEPT

##### Externes erlauben mit state #####
$IPT -A INPUT -p tcp -i $EXT -j tcp_accept
$IPT -A INPUT -p udp -i $EXT -j udp_accept
$IPT -A INPUT -p icmp -i $EXT -j icmp_accept
$IPT -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
$IPT -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT
$IPT -A OUTPUT -j ACCEPT

##### Forwarding #####
$IPT -A FORWARD -p tcp --dport 21 -j ACCEPT
#$IPT -A FORWARD -p tcp --dport 80 -j ACCEPT
$IPT -A FORWARD -p tcp --dport $ICQ_MSG_PORT -j ACCEPT
$IPT -A FORWARD -p tcp --dport $ICQ_FT_PORTS -j ACCEPT

##### NAT, Icq, etc weiterleiten #####
$IPT -t nat -A PREROUTING -i $EXT -p tcp --dport $ICQ_MSG_PORT -j DNAT --to $CLIENT
$IPT -t nat -A PREROUTING -i $EXT -p tcp --dport $ICQ_FT_PORTS -j DNAT --to $CLIENT

##### Masquerading
$IPT -t nat -A POSTROUTING -o $EXT -j MASQUERADE

