export const Text = ({ tag = 'p', children, ...rest }) => {
	const Tag = tag;
	return <Tag {...rest}>{children}</Tag>;
};
