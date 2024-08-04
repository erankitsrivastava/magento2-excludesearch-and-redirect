<?php
namespace Epurnima\ExcludeSearch\Plugin;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ExcludeSearchPlugin
{
    /**
     * @var RedirectInterface
     */
    protected $redirect;
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ExcludeSearchPlugin constructor.
     * @param RedirectInterface $redirect
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        RedirectInterface $redirect,
        RequestInterface $request,
        ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->redirect = $redirect;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param Action $subject
     */
    public function beforeExecute(Action $subject)
    {

        $searchQuery = $this->request->getParam('q', false);

        if(!$searchQuery) return;

        $keywordUrlPairs = $this->scopeConfig->getValue('exclude_search/general/keyword_url_pairs', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$keywordUrlPairs) {
            return;
        }

        $pairs = json_decode($keywordUrlPairs, true);

        if (!is_array($pairs)) {
            return;
        }


        foreach ($pairs as $pair) {
            $keyword = $pair['keyword'];
            $url = $pair['url'];
            if (strtolower($searchQuery) === strtolower($keyword) || strpos(strtolower($keyword), strtolower($searchQuery)) !== false) {
                $this->messageManager->addNoticeMessage(__('This search term is not allowed.'));
                $this->redirect->redirect($subject->getResponse(), $url);
                return;
            }
        }
    }
}
