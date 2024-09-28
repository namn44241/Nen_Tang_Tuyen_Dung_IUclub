import useTabs from "./useTabs";
import { TabHeader } from "..";
import { __ } from '@wordpress/i18n';

const Tab = ({ tabsData, onChange, activeTabTitle }) => {
	const { renderTabs, renderContent } = useTabs(tabsData, 0, onChange);

	const GetPro = () => {
		return (
			<>
				<div className="get-pro">
					<h3>{__('Jobscout Pro', 'jobscout')}</h3>
					<p>{__('Get access to all unlimited features.')}</p>
					<a className="cw-button-btn primary-btn" target="_blank" href={cw_dashboard.get_pro}>{__('Get Pro', 'jobscout')}</a>
				</div>
			</>
		);
	}

	return (
		<div className="cw-tabs-container">
			<div className="cw-tabs">
				<div className="wrapper">
					<div className="top">
						<div className="logo">
							<h1>{cw_dashboard.blog_name}</h1>
						</div>
						<div className="cw-tabs-button">
							{renderTabs()}
						</div>
					</div>
					{GetPro()}
				</div>

			</div>
			<div className="wrapper">
				<TabHeader title={activeTabTitle} />
				<div className="cw-tabs-content">
					{renderContent()}
				</div>
			</div>


		</div>
	);
};

export default Tab;