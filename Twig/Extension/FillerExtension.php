<?php
/**
 * Naneau Text Filler
 *
 * @category Naneau
 * @package Naneau_Text
 * @copyright Copyright (c) 2007 Maurice Fonk http://naneau.nl/
 * @license New BSD License
 * @version 0.1
 *
 * @note Extended to a Twig_Extension by <eduard.seifert@namics.com>
 * @lastmodified 20121102
 *
 * @usage
 * {{ w(2) }} // get words
 * {{ p(2) }} // get paragraphs
 *
 */
namespace Terrific\TwigExtensionsBundle\Twig\Extension {

    use Twig_Extension;
    use Twig_Function_Function;

    class FillerExtension extends \Twig_Extension {

        /**
         * the actual text
         *
         * @var array
         */
        private static $_lorem = array(
            'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent massa orci, ultrices nec, convallis non, pharetra at, felis. Integer vitae tortor luctus elit scelerisque vestibulum. Phasellus enim orci, dignissim eget, volutpat at, laoreet in, eros. Donec augue mi, nonummy in, pharetra at, volutpat sit amet, lacus. Etiam id lorem. Duis vitae augue. Ut tristique. Donec dignissim purus eget massa. Donec urna justo, ornare id, sagittis tempus, varius sit amet, dolor. Donec rhoncus dictum diam. Aenean erat lacus, nonummy id, euismod nec, molestie id, massa. Nullam accumsan mattis diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nullam suscipit. Sed elit arcu, dictum at, lobortis eget, adipiscing ut, tortor. Integer lobortis, sapien quis vulputate pellentesque, leo nulla consequat arcu, id vulputate erat leo nec nunc. Phasellus cursus, mi in nonummy condimentum, est augue congue nunc, ut cursus augue risus ac lorem. Quisque aliquam mauris at nibh. Mauris tristique.',
            'Proin posuere, mi iaculis viverra aliquet, orci lectus placerat eros, eu dapibus sem dolor in libero. Donec hendrerit molestie lorem. Morbi dolor orci, posuere vitae, rhoncus at, hendrerit a, velit. Etiam hendrerit felis id risus. Nulla ornare accumsan elit. Phasellus consectetuer, libero et tempus elementum, dui dolor malesuada nisl, eu malesuada dui nunc eu magna. Aenean sagittis pretium turpis. Donec suscipit. Integer tristique augue. In congue dignissim nunc. Donec risus dolor, varius vitae, faucibus in, rhoncus ut, risus. Nunc malesuada, diam non tempor ornare, enim purus commodo mauris, vitae suscipit massa ipsum eget ipsum. Nulla ac augue sit amet sapien porta vestibulum.',
            'Quisque sem. Sed metus quam, elementum interdum, aliquam eget, semper et, ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed eros. Sed ut erat id purus consequat fringilla. Nam id nulla. Curabitur et ligula. Cras eu pede. Praesent lacus libero, consectetuer non, accumsan a, dapibus eu, leo. Vestibulum nec arcu ut magna consequat laoreet.',
            'Vestibulum auctor tempus mauris. Pellentesque tempus varius metus. Vestibulum ac libero. Proin id sem. Sed nulla libero, tempus eget, auctor ac, sagittis sed, eros. Mauris condimentum pharetra ipsum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Vivamus commodo, libero et gravida commodo, eros felis venenatis neque, sit amet iaculis sapien quam ac mauris. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin ultrices. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nullam sem. Nullam velit. Cras et justo. Phasellus adipiscing. Aenean accumsan.',
            'Quisque placerat. Nulla et ante eu neque convallis lacinia. Duis ac enim ut libero scelerisque accumsan. Nulla a nunc sit amet nibh mattis lacinia. Vestibulum vulputate ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris sodales suscipit diam. Nam justo. Curabitur tincidunt purus ac tellus rhoncus tincidunt. Mauris nunc nibh, consectetuer et, tristique eget, suscipit ut, nunc. Donec quam tellus, molestie ac, consequat sed, gravida a, nibh. Sed non risus. Donec luctus.',
            'Nullam hendrerit molestie justo. Phasellus porttitor lacus vel ipsum. Nullam lectus tellus, lacinia sit amet, luctus varius, porta vitae, urna. Maecenas vehicula neque. Pellentesque gravida quam quis pede. Mauris eleifend massa vitae velit. Praesent ultrices vestibulum justo. Quisque eget orci. In ligula nisi, aliquam ac, condimentum non, scelerisque ut, elit. Fusce id felis eu ipsum eleifend posuere. Praesent eu orci nec turpis luctus pharetra. Nunc velit. Mauris vestibulum, diam et condimentum posuere, purus nisi ultricies leo, in volutpat metus tortor a odio. Maecenas sagittis, libero at fermentum faucibus, velit augue feugiat elit, eget adipiscing sapien neque in pede. Pellentesque in elit. Donec condimentum magna at odio. Sed placerat. Vestibulum dictum.',
            'Morbi bibendum sem in erat. Maecenas sit amet magna. Mauris ut purus quis metus rhoncus auctor. Phasellus facilisis magna eu diam. Pellentesque sit amet erat lobortis leo ultricies blandit. Donec ultrices libero ac mauris fringilla sagittis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Suspendisse eu velit. Suspendisse sed felis non ante mollis fermentum. Sed quam augue, varius eu, dignissim ut, fermentum quis, nulla. Curabitur ac massa sed pede tempor pretium. Fusce est. Sed dictum lorem ac arcu.',
            'Ut non ante at sem porttitor vulputate. Curabitur consectetuer justo sit amet justo. Praesent auctor ligula eu lacus. Duis tincidunt mattis felis. Mauris metus. Pellentesque vel magna in nisi sodales lacinia. Nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec lacinia eleifend libero. Donec ac odio. Nunc et est. Suspendisse fermentum, odio sit amet ullamcorper placerat, purus massa posuere mauris, eget lacinia pede augue et justo.',
            'Phasellus non justo nec sapien mattis blandit. Sed egestas libero vel ante. Mauris a velit ut leo sollicitudin dignissim. Donec ut justo id turpis interdum luctus. Fusce condimentum libero in arcu. Aliquam erat volutpat. Suspendisse sem. Nulla gravida. Cras ligula elit, bibendum quis, aliquet id, pretium bibendum, sapien. Vestibulum purus dolor, molestie ac, auctor et, sollicitudin id, risus. Curabitur justo mi, aliquam condimentum, dignissim sed, auctor nec, nisi.',
            'Aenean ultrices, leo id ultrices ultricies, orci nunc eleifend lectus, id pharetra nunc eros sit amet ipsum. Vivamus tellus nulla, porttitor volutpat, porta eu, nonummy id, lectus. Maecenas enim tellus, semper a, euismod ac, eleifend in, tellus. Cras ut lorem. Etiam vitae lectus eget ipsum vehicula adipiscing. Integer a nulla. Pellentesque sollicitudin odio ut dui. Aenean tincidunt lorem vel urna. Mauris est lectus, molestie at, cursus nec, laoreet ac, lorem. Pellentesque est ligula, dapibus ac, tristique non, placerat a, dui. Aenean quis nulla a est viverra venenatis. In eget elit non nibh mollis pellentesque. Nullam placerat faucibus velit. Sed fermentum, turpis sed auctor sodales, ipsum nisi fermentum urna, in vulputate odio nibh eu dolor. In hac habitasse platea dictumst. Aenean libero mauris, vulputate vitae, sodales malesuada, fringilla vel, eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nam iaculis augue vitae nisl. Maecenas tincidunt dictum velit.',
            'Fusce semper condimentum risus. In rhoncus. Sed interdum, eros a iaculis eleifend, velit sem porttitor libero, eu tristique nisi lorem sit amet magna. Aliquam eget lorem eget metus vestibulum molestie. Suspendisse condimentum, nulla vitae euismod imperdiet, mi mauris tincidunt turpis, et vulputate erat turpis eu est. Suspendisse auctor gravida nisl. Duis dictum vestibulum odio. Nunc bibendum ligula vel arcu. Integer quam elit, rhoncus nec, sodales sit amet, rhoncus eu, dui. Aenean feugiat faucibus eros. Praesent rhoncus, elit sit amet dictum varius, nisi mauris hendrerit ante, in egestas urna velit venenatis libero. Cras enim dui, fringilla vitae, dapibus a, tristique sit amet, lorem. Vestibulum porttitor velit elementum nisi. In vel magna. Donec eu risus.',
            'Phasellus at felis. Donec dui nulla, posuere sit amet, interdum ac, lacinia ut, libero. Nunc in nulla. Nam consequat. Mauris in erat. Pellentesque laoreet risus ac metus. Nam non ipsum. Vestibulum massa. Sed ultrices. Vestibulum sollicitudin, nulla non accumsan tincidunt, lacus sapien sollicitudin dui, in sodales tellus arcu vitae dui. In gravida magna a tortor. Donec luctus sem a lorem. Aliquam erat volutpat. Fusce aliquam viverra arcu. Phasellus id sem. Aenean eros. Pellentesque ac massa sed eros laoreet fermentum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
            'Pellentesque congue scelerisque arcu. Vestibulum eget risus laoreet sem elementum pellentesque. Vivamus sollicitudin. Nulla ut leo in libero aliquam convallis. Etiam et quam vel odio malesuada pharetra. Pellentesque non velit. Pellentesque auctor lacinia dui. Curabitur laoreet dui a dui. Donec quis tortor. Suspendisse in urna in ante elementum dapibus. Aliquam ut metus. Vestibulum tincidunt, massa sed porta imperdiet, enim arcu semper justo, ac feugiat nisi ipsum in lacus. Nunc a metus. Donec nunc justo, facilisis eu, elementum sed, mollis in, pede. Cras tincidunt varius velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.',
            'Ut feugiat, ipsum vel pharetra tincidunt, tortor ipsum rutrum est, in rutrum pede lectus vel elit. Suspendisse potenti. Aenean vitae sem. Morbi odio ante, condimentum ut, pretium non, lobortis venenatis, turpis. In hac habitasse platea dictumst. Aenean porta, orci quis dapibus venenatis, diam dui interdum mi, sed accumsan neque est vitae nibh. Aenean a dolor. Sed enim. Sed nonummy mollis nunc. Etiam et tortor. Aliquam malesuada elit vel lorem. Sed sodales nisi a turpis. Ut at urna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut sagittis turpis vitae odio malesuada semper.',
            'Donec condimentum. Pellentesque scelerisque nulla. Praesent ac nibh a felis placerat eleifend. Nullam eleifend felis nec dui. Nunc venenatis porta odio. Pellentesque porta blandit lectus. Donec nisl metus, vestibulum non, sodales vitae, lacinia viverra, libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Aliquam mollis hendrerit odio. Integer a sapien ac mi tempus sollicitudin. Aliquam erat volutpat. Praesent facilisis felis non dui. Duis eu orci. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Duis elementum nisi. Integer faucibus neque at pede. Maecenas quis elit id purus luctus consectetuer.'
        );

        /**
         * Get a number of paragraphs,
         *
         * if you want them wrapped in html paragraph notation, pass a second parameter true
         *
         * @param int $count
         * @param bool $html
         * @return string
         */
        public function getParagraphs($count, $html = false) {
            $nPar = count(self::$_lorem);
            //number of paragraphs
            if ($count > $nPar) {
                $count = $nPar;
            }
            //never more than $nPar parapagraphs

            $return = '';
            //return string

            $lines = self::$_lorem;
            shuffle($lines);

            for ($x = 0; $x < $count; $x++) {
                if ($html) {
                    $return .= "<p>" . $lines[$x] . "</p>\n";
                }
                else {
                    $return .= $lines[$x] . "\n\n";
                }
            }
            //beautify result and wrap in html if necessary

            return $return;
        }

        /**
         * get a number of words,
         *
         * pass false as a second parameter to stop capitalization
         *
         * @param int $count
         * @param bool $capitalize
         * @return string
         */
        public function getWords($count, $capitalize = true) {
            $par = rand(0, count(self::$_lorem) - 1);
            //random paragraph

            $line = str_replace(array('.', ','), '', self::$_lorem[$par]);
            $words = explode(' ', $line);
            shuffle($words);
            //words

            $nWords = count($words);
            if ($count > $nWords) {
                $count = $nWords;
            }
            //never more than $nWords

            $return = '';
            for ($x = 0; $x < $count; $x++) {
                $return .= strtolower($words[$x]) . ' ';
                //make lower case
            }
            if ($capitalize) {
                $return = strtoupper(substr($return, 0, 1)) . substr($return, 1);
            }
            //capitalize first if necessary

            return trim($return);
            //return result
        }

        /**
         * Returns the name of the extension.
         *
         * @return string The extension name
         */
        public function getName()
        {
            return "TwigExtensionsBundle_FillerExtension";
        }

        /**
         * @return array
         */
        public function getFunctions()
        {
            return array(
                'w' => new \Twig_Function_Method($this, 'getWords'),
                'p' => new \Twig_Function_Method($this, 'getParagraphs')
            );
        }
   }
}
