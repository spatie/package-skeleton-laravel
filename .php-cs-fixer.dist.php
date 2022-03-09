<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()->in([
    'config',
    'database',
    'src',
    'tests',
]);

return (new PhpCsFixer\Config())->setRules([
    /*
     * Alias
     */
    'array_push' => false, // risky
    'backtick_to_shell_exec' => true,
    'ereg_to_preg' => true, // risky
    'mb_str_functions' => true, // risky
    'no_alias_functions' => ['sets' => ['@all']], // risky
    'no_alias_language_construct_call' => true,
    'no_mixed_echo_print' => ['use' => 'echo'],
    'pow_to_exponentiation' => true, // risky
    'random_api_migration' => true, // risky
    'set_type_to_cast' => true, // risky
    /*
     * Array notation
     */
    'array_syntax' => ['syntax' => 'short'],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_whitespace_before_comma_in_array' => ['after_heredoc' => true],
    'normalize_index_brace' => true,
    'trim_array_spaces' => true,
    'whitespace_after_comma_in_array' => true,
    /*
     * Basic
     */
    'braces' => [
        'allow_single_line_anonymous_class_with_empty_body' => true,
        'allow_single_line_closure' => true,
        'position_after_functions_and_oop_constructs' => 'next',
        'position_after_control_structures' => 'same',
        'position_after_anonymous_constructs' => 'same',
    ],
    'encoding' => true,
    'non_printable_character' => ['use_escape_sequences_in_strings' => true], // risky
    'octal_notation' => true,
    'psr_autoloading' => true, // risky
    /*
     * Casing
     */
    'class_reference_name_casing' => true,
    'constant_case' => ['case' => 'lower'],
    'integer_literal_case' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'native_function_casing' => true,
    'native_function_type_declaration_casing' => true,
    /*
     * Cast Notation
     */
    'cast_spaces' => ['space' => 'single'],
    'lowercase_cast' => true,
    'modernize_types_casting' => true, // risky
    'no_short_bool_cast' => true,
    'no_unset_cast' => true,
    'short_scalar_cast' => true,
    /*
     * Class Notation
     */
    'class_attributes_separation' => ['elements' => ['const' => 'one', 'method' => 'one', 'property' => 'one', 'trait_import' => 'none', 'case' => 'none']],
    'class_definition' => [
        'multi_line_extends_each_single_line' => false,
        'single_item_single_line' => false,
        'single_line' => false,
    ],
    'final_class' => false, // risky
    'final_internal_class' => false, // risky
    'final_public_method_for_abstract_class' => false, // risky
    'no_blank_lines_after_class_opening' => true,
    'no_null_property_initialization' => false,
    'no_php4_constructor' => true, // risky
    'no_unneeded_final_method' => true, // risky
    'ordered_class_elements' => ['order' => ['use_trait', 'constant', 'property_static', 'property', 'case', 'construct']],
    'ordered_interfaces' => ['order' => 'alpha', 'direction' => 'ascend'], // risky
    'ordered_traits' => true, // risky
    'protected_to_private' => false,
    'self_accessor' => true, // risky
    'self_static_accessor' => true,
    'single_class_element_per_statement' => true,
    'single_trait_insert_per_statement' => true,
    'visibility_required' => ['elements' => ['property', 'method', 'const']],
    /*
     * Class Usage
     */
    'date_time_immutable' => true, // risky
    /*
     * Comment
     */
    'comment_to_phpdoc' => true, // risky
    'header_comment' => false,
    'multiline_comment_opening_closing' => true,
    'no_empty_comment' => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_line_comment_spacing' => true,
    'single_line_comment_style' => ['comment_types' => ['hash']],
    /*
     * Constant Notation
     */
    'native_constant_invocation' => false, // risky
    /*
     * Control structures
     */
    'control_structure_continuation_position' => ['position' => 'same_line'],
    'elseif' => true,
    'empty_loop_body' => ['style' => 'semicolon'],
    'empty_loop_condition' => ['style' => 'while'],
    'include' => true,
    'no_alternative_syntax' => true,
    'no_break_comment' => true,
    'no_superfluous_elseif' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unneeded_curly_braces' => true,
    'no_useless_else' => true,
    'simplified_if_return' => false,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'switch_continue_to_break' => true,
    'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => ['arrays', 'parameters']],
    'yoda_style' => [
        'always_move_variable' => false,
        'equal' => false,
        'identical' => false,
        'less_and_greater' => null,
    ],
    /*
     * Doctrine Annotation
     */
    // skipped
    /*
     * Function Notation
     */
    'combine_nested_dirname' => true, // risky
    'fopen_flag_order' => true, // risky
    'fopen_flags' => ['b_mode' => false], // risky
    'function_declaration' => ['closure_function_spacing' => 'one', 'trailing_comma_single_line' => false],
    'function_typehint_space' => true,
    'implode_call' => true, // risky
    'lambda_not_used_import' => true,
    'method_argument_space' => [
        'keep_multiple_spaces_after_comma' => false,
        'on_multiline' => 'ensure_fully_multiline',
        'after_heredoc' => true,
    ],
    'native_function_invocation' => [  // risky
        'include' => ['@compiler_optimized'],
        'scope' => 'namespaced',
        'strict' => true,
    ],
    'no_spaces_after_function_name' => true,
    'no_trailing_comma_in_singleline_function_call' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_sprintf' => true,
    'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => true],
    'phpdoc_to_param_type' => false, // experimental, risky
    'phpdoc_to_property_type' => false, // experimental, risky
    'phpdoc_to_return_type' => false, // experimental, risky
    'regular_callable_call' => true, // risky
    'return_type_declaration' => true,
    'single_line_throw' => false,
    'static_lambda' => false, // risky
    'use_arrow_functions' => false, // risky
    'void_return' => true, // risky
    /*
     * Import
     */
    'fully_qualified_strict_types' => true,
    'global_namespace_import' => ['import_constants' => false, 'import_functions' => true, 'import_classes' => true],
    'group_import' => false,
    'no_leading_import_slash' => true,
    'no_unneeded_import_alias' => true,
    'no_unused_imports' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha', 'imports_order' => ['class', 'function', 'const']],
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    /*
     * Language Construct
     */
    'class_keyword_remove' => false,
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'declare_equal_normalize' => ['space' => 'none'],
    'declare_parentheses' => true,
    'dir_constant' => true, // risky
    'error_suppression' => false,
    'explicit_indirect_variable' => true,
    'function_to_constant' => [
        'functions' => [
            'get_called_class',
            'get_class',
            'get_class_this',
            'php_sapi_name',
            'phpversion',
            'pi',
        ],
    ], // risky
    'get_class_to_class_keyword' => true, // risky
    'is_null' => true,
    'no_unset_on_property' => false, // risky
    'single_space_after_construct' => true,
    /*
     * List Notation
     */
    'list_syntax' => ['syntax' => 'short'],
    /*
     * Namespace Notation
     */
    'blank_line_after_namespace' => true,
    'clean_namespace' => true,
    'no_blank_lines_before_namespace' => false,
    'no_leading_namespace_whitespace' => true,
    'single_blank_line_before_namespace' => true,
    /*
     * Naming
     */
    'no_homoglyph_names' => false, // risky
    /*
     * Operator
     */
    'assign_null_coalescing_to_coalesce_equal' => true,
    'binary_operator_spaces' => ['default' => 'single_space'],
    'concat_space' => ['spacing' => 'one'],
    'increment_style' => false,
    'logical_operators' => true,
    'new_with_braces' => true,
    'no_space_around_double_colon' => true,
    'not_operator_with_space' => false,
    'not_operator_with_successor_space' => false,
    'object_operator_without_whitespace' => true,
    'operator_linebreak' => ['only_booleans' => true, 'position' => 'beginning'],
    'standardize_increment' => false,
    'standardize_not_equals' => true,
    'ternary_to_elvis_operator' => true, // risky
    'ternary_to_null_coalescing' => true,
    'unary_operator_spaces' => true,
    /*
     * PHP Tag
     */
    'blank_line_after_opening_tag' => false,
    'echo_tag_syntax' => false,
    'full_opening_tag' => true,
    'linebreak_after_opening_tag' => false,
    'no_closing_tag' => true,
    /*
     * PHPUnit
     */
    'php_unit_construct' => true, // risky
    'php_unit_dedicate_assert' => true, // risky
    'php_unit_dedicate_assert_internal_type' => true, // risky
    'php_unit_expectation' => true, // risky
    'php_unit_fqcn_annotation' => true,
    'php_unit_internal_class' => false,
    'php_unit_method_casing' => ['case' => 'camel_case'],
    'php_unit_mock' => true, // risky
    'php_unit_mock_short_will_return' => true, // risky
    'php_unit_namespaced' => true, // risky
    'php_unit_no_expectation_annotation' => true, // risky
    'php_unit_set_up_tear_down_visibility' => true, // risky
    'php_unit_size_class' => false,
    'php_unit_strict' => false, // risky
    'php_unit_test_annotation' => ['style' => 'annotation'], // risky
    'php_unit_test_case_static_method_calls' => ['call_type' => 'this'], // risky
    'php_unit_test_class_requires_covers' => true,
    /*
     * PHPDoc
     */
    'align_multiline_comment' => true,
    'general_phpdoc_annotation_remove' => ['annotations' => ['author', 'class', 'namespace']],
    'general_phpdoc_tag_rename' => false,
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_phpdoc' => true,
    'no_superfluous_phpdoc_tags' => [
        'allow_mixed' => true,
        'remove_inheritdoc' => true,
        'allow_unused_params' => false,
    ],
    'phpdoc_add_missing_param_annotation' => ['only_untyped' => true],
    'phpdoc_align' => [
        'align' => 'left',
        'tags' => [
            'param',
            'property',
            'property-read',
            'property-write',
            'return',
            'throws',
            'type',
            'var',
            'method',
        ],
    ],
    'phpdoc_annotation_without_dot' => true,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag_normalizer' => true,
    'phpdoc_line_span' => ['const' => 'single', 'property' => 'single', 'method' => 'multi'],
    'phpdoc_no_access' => true,
    'phpdoc_no_alias_tag' => ['replacements' => ['type' => 'var', 'link' => 'see']],
    'phpdoc_no_empty_return' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_order_by_value' => ['annotations' => ['covers', 'throws']],
    'phpdoc_order' => true,
    'phpdoc_return_self_reference' => false,
    'phpdoc_scalar' => true,
    'phpdoc_separation' => false,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    'phpdoc_tag_casing' => false,
    'phpdoc_tag_type' => false,
    'phpdoc_to_comment' => false,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'alpha'],
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_var_without_name' => true,
    /*
     * Return Notation
     */
    'no_useless_return' => true,
    'return_assignment' => true,
    'simplified_null_return' => true,
    /*
     * Semicolon
     */
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
    'no_empty_statement' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'semicolon_after_instruction' => true,
    'space_after_semicolon' => ['remove_in_empty_for_expressions' => true],
    /*
     * Strict
     */
    'declare_strict_types' => true, // risky
    'strict_comparison' => false, // risky
    'strict_param' => false, // risky
    /*
     * String Notation
     */
    'escape_implicit_backslashes' => ['single_quoted' => false, 'double_quoted' => true, 'heredoc_syntax' => true],
    'explicit_string_variable' => true,
    'heredoc_to_nowdoc' => true,
    'no_binary_string' => true,
    'no_trailing_whitespace_in_string' => false, // risky
    'simple_to_complex_string_variable' => true,
    'single_quote' => true,
    'string_length_to_empty' => true,
    'string_line_ending' => false, // risky
    /*
     * Whitespace
     */
    'array_indentation' => true,
    'blank_line_before_statement' => ['statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try']],
    'compact_nullable_typehint' => true,
    'heredoc_indentation' => ['indentation' => 'same_as_start'],
    'indentation_type' => true,
    'line_ending' => true,
    'method_chaining_indentation' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
            'use_trait',
        ],
    ],
    'no_spaces_around_offset' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'single_blank_line_at_eof' => true,
    'types_spaces' => true,
])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
