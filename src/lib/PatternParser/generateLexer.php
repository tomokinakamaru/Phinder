<?php

function getGrammar()
{
    return file_get_contents('Parser.phpy');
}

function getTokens($grammar)
{
    $tokens = [];
    foreach (explode(PHP_EOL, $grammar) as $line) {
        if ((strpos($line, '%token') === 0)) {
            $body = substr($line, strlen('%token') + 1);
            $arr = explode(' ', $body, 2);
            $tokens[] = [
                'name' => $arr[0],
                'regex' => unescape(substr($arr[1], 1, strlen($arr[1]) - 2), "'"),
            ];
        }
    }

    return $tokens;
}

function buildRegex($tokens)
{
    $regs = ['\t+|\s+'];
    foreach ($tokens as $token) {
        $n = $token['name'];
        $r = escape($token['regex'], '"');
        $r = escape($r, '/');
        $r = trim($r);
        $regs[] = "(?<$n>$r)";
    }

    $regex = implode('|', $regs);

    return "^($regex)";
}

function getTemplate()
{
    return file_get_contents('Lexer.template');
}

function unescape($string, $escapedChar)
{
    $result = '';
    for ($i = 0; $i < strlen($string); ++$i) {
        $cur = $string[$i];
        if ($cur === '\\') {
            $next = $string[$i + 1];
            if ($next === $escapedChar) {
                $result .= $next;
                ++$i;
            } else {
                $result .= '\\';
            }
        } else {
            $result .= $cur;
        }
    }

    return $result;
}

function escape($string, $escapeChar)
{
    $result = '';
    for ($i = 0; $i < strlen($string); ++$i) {
        $cur = $string[$i];
        if ($cur === $escapeChar) {
            $result .= "\\$cur";
        } else {
            $result .= $cur;
        }
    }

    return $result;
}

$grammar = getGrammar();

$tokens = getTokens($grammar);

$regex = buildRegex($tokens);

echo "<?php\n\n";
?>
namespace Phinder\PatternParser;

class Lexer
{
    private static $_regex = "<?php echo $regex; ?>";

    private $_string;

    public function __construct($string)
    {
        $this->_string = $string;
    }

    public function getToken(&$val)
    {
        $matches = [];
        if (preg_match(self::$_regex, $string, $matches, PREG_UNMATCHED_AS_NULL)) {
<?php foreach ($tokens as $token): ?>
            if ($matches['<?php echo $token['name']; ?>'] !== null) {
                $val = $matches['<?php echo $token['name']; ?>'];
                $this->_string = substr($this-_string, strlen($val));
                return Parser::<?php echo $token['name']; ?>;
            }
<?php endforeach; ?>
        }
        return Parser::YYERRTOK;
    }
}
