<?php
/**
 * App api
 *
 * @since      1.0.0
 * @author     Beeketing
 *
 */

namespace Beeketing\BoostSales\Api;


use Beeketing\BoostSales\Data\Constant;
use BKBoostSalesSDK\Api\CommonApi;
use BKBoostSalesSDK\Data\AppCodes;
use BKBoostSalesSDK\Libraries\SettingHelper;

class App extends CommonApi
{
    private $api_key;

    /**
     * App constructor.
     *
     * @param $api_key
     */
    public function __construct( $api_key )
    {
        $this->api_key = $api_key;
        $setting_helper = new SettingHelper();
        $setting_helper->set_app_setting_key( \BKBoostSalesSDK\Data\AppSettingKeys::BOOSTSALES_KEY );
        $setting_helper->set_plugin_version( BOOSTSALES_VERSION );

        parent::__construct(
            $setting_helper,
            BOOSTSALES_PATH,
            BOOSTSALES_API,
            $api_key,
            AppCodes::BOOSTSALES,
            Constant::PLUGIN_ADMIN_URL
        );
    }

    /**
     * Get routers
     *
     * @return array
     */
    public function get_routers()
    {
        $result = $this->get( 'bsales/routers' );

        if ( $result && !isset( $result['errors'] ) ) {
            foreach ( $result as &$item ) {
                if ( strpos( $item, 'http' ) === false ) {
                    $end_point = BOOSTSALES_PATH;
                    if ( BOOSTSALES_ENVIRONMENT == 'local' ) {
                        $end_point = str_replace( '/app_dev.php', '', $end_point );
                    }
                    $item = $end_point . $item;
                }
            }

            return $result;
        }

        return array();
    }

    /**
     * Get api urls
     *
     * @return array
     */
    public function get_api_urls()
    {
        return array_merge( array(
            'app_data' => $this->get_url( 'bsales/data' ),
            'report_overview' => $this->get_url( 'bsales/reports/overview' ),
            'report_quick_view' => $this->get_url( 'bsales/reports/quick_view' ),
        ), parent::get_api_urls() );
    }
}