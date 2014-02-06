<?php
/**
 * Class Hunspell
 */
class Hunspell {
    /**
     * @var string
     */
    protected $cmd = 'echo %s | /usr/bin/hunspell';

    /**
     * @param string $input
     * @return array
     */
    public function check($input) {
        exec(sprintf($this->cmd, escapeshellarg($input)), $lines);
        return $this->process($lines);
    }

    /**
     * @param array $lines
     * @return array
     */
    protected function process(array $lines) {
        $results = [];
        foreach (array_slice($lines, 1) as $line) {
            if (preg_match('/^\&\s+([^\s]+)[0-9\s]+\:(.+)/', trim($line), $matches)) {
                $suggestions = explode(',', $matches[2]);
                $suggestions = array_map('trim', $suggestions);
                $results[trim($matches[1])] = $suggestions;
            }
        }
        return $results;
    }
}
