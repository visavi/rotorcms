<?php

namespace JBBCode\visitors;

class SmilesVisitor implements \JBBCode\NodeVisitor
{

    function visitDocumentElement(\JBBCode\DocumentElement $documentElement)
    {
        foreach($documentElement->getChildren() as $child) {
            $child->accept($this);
        }
    }

    function visitTextNode(\JBBCode\TextNode $textNode)
    {

        static $list_smiles;

        if (empty($list_smiles)) {

            if (!file_exists(DATADIR."/temp/smiles.dat")) {

                $smiles = \Smile::all(array('order' => 'LENGTH(code) desc'));
                $smiles = \ActiveRecord\assoc($smiles, 'code', 'name');
                file_put_contents(DATADIR."/temp/smiles.dat", serialize($smiles));
            }

            $list_smiles = unserialize(file_get_contents(DATADIR."/temp/smiles.dat"));
        }

        foreach($list_smiles as $code => $smile) {
            $textNode->setValue(str_replace($code, '<img src="/images/smiles/'.$smile.'" alt="'.$code.'" /> ', $textNode->getValue()));
        }

    }

    function visitElementNode(\JBBCode\ElementNode $elementNode)
    {
        /* We only want to visit text nodes within elements if the element's
         * code definition allows for its content to be parsed.
         */
        if ($elementNode->getCodeDefinition()->parseContent()) {
            foreach ($elementNode->getChildren() as $child) {
                $child->accept($this);
            }
        }
    }

}
