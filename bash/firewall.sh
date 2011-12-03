#!/bin/bash


# iptables
IPT="/sbin/iptables"

# internal interface eth0
INTIF="eth0"

# internal network address
INTNET="192.168.100.0/24"
INTNETV="192.168.100.0/24"

# internal lan ip
INTIP="192.168.100.1"
CAPTAIN="192.168.100.1"

# external adsl interface
EXTIF="ppp0"

# external ip
EXTIP="`/usr/bin/showip`"

# ports
HTTP="xxxx"
SSH="xxxx"

##### kernel modules
echo "Loading required stateful/NAT kernel modules..."

/sbin/depmod -a
/sbin/modprobe ip_tables
/sbin/modprobe ip_conntrack
/sbin/modprobe ip_conntrack_ftp
/sbin/modprobe ip_conntrack_irc
/sbin/modprobe iptable_nat
/sbin/modprobe ip_nat_ftp
/sbin/modprobe ip_nat_irc


echo "    Enabling IP forwarding"
echo "1" > /proc/sys/net/ipv4/ip_forward
echo "1" > /proc/sys/net/ipv4/ip_dynaddr

echo "    External interface: $EXTIF"
echo "       External interface IP address is: $EXTIP"
echo "    Loading firewall server rules..."

UNIVERSE="0.0.0.0/0"

# Clear any existing rules and setting default policy to DROP
$IPT -P INPUT DROP
$IPT -F INPUT 
$IPT -P OUTPUT DROP
$IPT -F OUTPUT 
$IPT -P FORWARD DROP
$IPT -F FORWARD 
$IPT -F -t nat

# Delete all User-specified chains
$IPT -X

# Reset all IPTABLES counters
$IPT -Z


## ACHTUNG, NUR WICHTIG UM ALTE EINTRAEGE ZU LOESCHEN DER VORGAENGERFIREWALL
# Flush the user chain.. if it exists
if [ "`iptables -L | grep drop-and-log-it`" ]; then
   $IPT -F drop-and-log-it
fi

# ping erlauben
$IPT -A INPUT -p icmp --icmp-type 8 -j ACCEPT

# loopback regeln
$IPT -A INPUT  -i lo -j ACCEPT
$IPT -A OUTPUT -o lo -j ACCEPT

# LAN freigeben
$IPT -A INPUT -i $INTIF -j ACCEPT
$IPT -A FORWARD -i $INTIF -j ACCEPT
$IPT -A OUTPUT -j ACCEPT

# bestehende verbindungen erlauben
$IPT -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
$IPT -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT

# forward regeln
$IPT -A FORWARD -d $CAPTAIN -p tcp --dport $SSH -j ACCEPT
$IPT -A FORWARD -d $CAPTAIN -p tcp --dport $HTTP -j ACCEPT

# nat
#$IPT -t nat -A POSTROUTING -o $EXTIF -j MASQUERADE
$IPT -t nat -A POSTROUTING -o $EXTIF -j SNAT --to $EXTIP
$IPT -t nat -A PREROUTING -i $EXTIF -d $EXTIP -p tcp --dport $HTTP -j DNAT --to $CAPTAIN
$IPT -t nat -A PREROUTING -i $EXTIF -d $EXTIP -p tcp --dport $SSH -j DNAT --to $CAPTAIN

$IPT -A INPUT -s 192.168.100.4 -d 192.168.100.1 -p tcp --dport 22 -j ACCEPT

route add -net 192.168.100.0 netmask 255.255.255.0  gw 192.168.100.1
