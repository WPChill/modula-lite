// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';


class ClassModulaDiviBlock extends Component {

  static slug = 'modula_divi_block';

  render() {
    const Content = this.props.content;

    return (
      <h1>
        <Content/>
      </h1>
    );
  }
}

export default ClassModulaDiviBlock;
