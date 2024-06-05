<?php

namespace App\Services;

class ZKTecoService
{
    protected $ip;
    protected $port;
    protected $socket;

    public function __construct($ip = '212.72.131.20', $port = '4370')
    {
        $this->ip = $ip;
        $this->port = $port;
    }

    private function connect()
    {
        $this->socket = fsockopen($this->ip, $this->port, $errno, $errstr, 30);

        if (!$this->socket) {
            throw new \Exception("Could not connect to device: $errstr ($errno)");
        }
    }

    private function disconnect()
    {
        fclose($this->socket);
    }

    private function sendCommand($command)
    {
        fwrite($this->socket, $command);
        $response = fread($this->socket, 8192); // Adjust buffer size if needed
        return $response;
    }

    private function createCommand($commandId, $parameters = '')
    {
        $header = "\x50\x50"; // Example header, might be different
        $length = pack('V', strlen($parameters) + 8); // Length of the command including header and parameters
        $command = pack('v', $commandId); // Command ID packed as a 2-byte integer
        $checksum = pack('v', 0); // Placeholder for checksum, usually calculated later

        // Concatenate parts to form the command
        $commandString = $header . $length . $command . $checksum . $parameters;

        // Calculate checksum
        $checksum = $this->calculateChecksum($commandString);
        $commandString = substr_replace($commandString, $checksum, 6, 2);

        return $commandString;
    }

    private function calculateChecksum($data)
    {
        $checksum = 0;
        for ($i = 0; $i < strlen($data); $i++) {
            $checksum += ord($data[$i]);
        }
        return pack('v', $checksum);
    }

    public function getAttendance()
    {
        $this->connect();

        $command = $this->createCommand(1100); // Example command ID for fetching attendance
        $response = $this->sendCommand($command);

        $this->disconnect();

        return $this->parseAttendanceData($response);
    }

    private function parseAttendanceData($data)
    {
        // Implement the specific parsing logic for the attendance data
        $attendanceData = []; // Parse $data to fill this array

        // Placeholder parsing logic
        // Assuming each record is a fixed length binary string
        $recordLength = 16; // Example length, replace with actual length
        for ($i = 0; $i < strlen($data); $i += $recordLength) {
            $record = substr($data, $i, $recordLength);
            $attendanceData[] = [
                'user_id' => unpack('V', substr($record, 0, 4))[1],
                'timestamp' => unpack('V', substr($record, 4, 4))[1],
                'status' => unpack('C', substr($record, 8, 1))[1],
            ];
        }

        return $attendanceData;
    }
}
