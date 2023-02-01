import { StatusBar } from 'expo-status-bar';
import { SafeAreaView } from 'react-native-safe-area-context';
import { StyleSheet, Text, TouchableOpacity, View, Image, TextInput, Button, ScrollView, FlatList} from 'react-native';
import { useEffect, useState } from 'react';

const VisitData = ({item}) => {
    //array con los meses del año
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    
    return(
        <View style={{marginBottom: 20}}>
            <Text style={{fontSize: 16, color:'#EFF3F5', marginBottom: 5, marginLeft: 20, fontWeight: '600'}}>{months[item.mes-1]} / {item.anio}:</Text>
            <Text style={{fontSize: 16, color:'#C8CDD0', marginBottom: 5, marginLeft: 20}}>     NA: {item.visitasNacionales}</Text>
            <Text style={{fontSize: 16, color:'#C8CDD0', marginBottom: 5, marginLeft: 20}}>     EX: {item.visitasExtranjeras}</Text>
            <Text style={{fontSize: 16, color:'#C8CDD0', marginBottom: 5, marginLeft: 20}}>     Totales: {item.visitasTotales}</Text>
        </View>
        
    );
}

//https://projectatp.000webhostapp.com/SSPBD/ExtractVisitsInfo.php

export default function CenterInfo({navigation, route}) {
    const {centro, estado, idCentro, imagenURL, municipio, tipoCentro} = route.params;
    const [DATA, setDATA] = useState([]);

    useEffect(()=> {
        const extractData = async () => {
            const url = 'https://projectatp.000webhostapp.com/SSPBD/ExtractVisitsInfo.php';
            const query = `?centerID=${idCentro}`;

            const petition = await fetch(url + query);
            const response = await petition.json();

            setDATA(response);
            console.log(response);
        }

        extractData();
    }, []);

    return (
        <SafeAreaView style={styles.mainContainer}>
            <Image
                style={styles.centerImage}
                source={{uri: imagenURL}}
            />

            <View style={styles.centerInfoContainer}>
                <Text style={{fontSize: 28, fontWeight: '600', color:'#EFF3F5'}}>{centro}</Text>
                <Text style={{fontSize: 16, color:'#C8CDD0', marginTop: 5}}>{estado}, {municipio}</Text>
                <Text style={{fontSize: 16, color:'#C8CDD0', marginTop: 5}}>{tipoCentro}</Text>
            </View>

            <View style={styles.centerVisitsContainer}>
                <Text style={{fontSize: 20, fontWeight: '600', color:'#EFF3F5', marginBottom: 10}}>Visitas:</Text>
                <FlatList
                    data = {DATA}
                    keyExtractor = {(item) => item.idVisitasMes}
                    renderItem = {VisitData}
                />
            </View>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    mainContainer: {
        flex: 1,
        width: '100%',
        backgroundColor: '#192229',
        alignItems: 'center',
    },
    centerImage: {
        width: '100%',
        height: '25%',
        resizeMode: 'stretch',
    },
    centerInfoContainer: {
        padding: 10,
        width: '100%',
    },
    centerVisitsContainer: {
        width: '90%',
        height: '52%',
        marginTop: 20,
        backgroundColor: '#2A3B47',
        borderRadius: 10,
        padding: 10,
    }
});