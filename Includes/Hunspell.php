<?php
class Hunspell {
    protected $cmd = 'echo %s | /usr/bin/hunspell';

    public function check($input) {
        exec(sprintf($this->cmd, escapeshellarg($input)), $output);
        return $this->process($output);
    }

    protected function process($output) {
        $results = [];
        foreach (array_slice($output, 1) as $line) {
            if (preg_match('/^\&\s+([^\s]+)[0-9\s]+\:(.+)/', trim($line), $matches)) {
                $suggestions = explode(',', $matches[2]);
                $suggestions = array_map('trim', $suggestions);
                $results[trim($matches[1])] = $suggestions;
            }
        }
        return $results;
    }
}
